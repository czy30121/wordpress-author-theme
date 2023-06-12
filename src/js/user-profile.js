// =============================================================================
// UNSET OAUTH CONNECTION
// =============================================================================

/**
 * Unset OAuth connection.
 *
 * @description Requests the deletion of an OAuth connection via AJAX, which
 * must be confirmed in a prompt with a localized confirmation string (DELETE
 * per default). In case this function is called maliciously, the request is
 * validated server-side as well.
 *
 * @since 4.5
 * @param {String} none - Nonce for the action.
 * @param {String} channel - The OAuth channel to delete.
 * @param {Number} id - The ID of the user.
 */

function fcn_unsetOauth(nonce, channel, id) {
  // Confirm deletion request using localized string
  let confirm = prompt(
    sprintf(
      _x('Are you sure? Note that if you disconnect all accounts, you may no longer be able to log back in once you log out. Enter %s to confirm.', 'Unset OAuth prompt.', 'fictioneer'),
      _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toUpperCase()
    )
  );

  if (
    !confirm ||
    confirm.toLowerCase() != _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toLowerCase()
  ) return;

  let connection = _$$$(`oauth-${channel}`);

  // Mark as in-progress
  connection.classList.add('ajax-in-progress');

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_unset_my_oauth',
    'nonce': nonce,
    'channel': channel,
    'id': id
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    if (response.success) {
      // Successfully unset
      connection.classList.remove('_connected');
      connection.classList.add('_disconnected');
      connection.querySelector('button').remove();
      fcn_showNotification(connection.dataset.unset);
    } else {
      // Failed to unset
      connection.style.background = 'var(--warning)';
      fcn_showNotification(response.data.error, 5, 'warning');
    }
  })
  .catch((error) => {
    if (error.status && error.statusText) {
      connection.style.background = 'var(--warning)';
      fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
    }
  })
  .then(() => {
    // Regardless of outcome
    connection.classList.remove('ajax-in-progress');
  });
}

// Listen to click on unset buttons
_$$('.button-unset-oauth').forEach(element => {
  element.addEventListener(
    'click',
    e => {
      fcn_unsetOauth(
        e.currentTarget.dataset.nonce,
        e.currentTarget.dataset.channel,
        e.currentTarget.dataset.id
      );
    }
  );
});

// =============================================================================
// DELETE MY ACCOUNT
// =============================================================================

/**
 * Delete an user's account on request.
 *
 * @description Requests the deletion of an account via AJAX, which must be
 * confirmed in a prompt with a localized confirmation string (DELETE per
 * default). Roles above subscribers cannot delete their account this way.
 * In case this function is called maliciously, the request is validated
 * server-side as well.
 *
 * @since 4.5
 * @param {HTMLElement} button - The clicked button.
 */

function fcn_deleteMyAccount(button) {
  if (_$$$('button-delete-my-account').hasAttribute('disabled')) return;

  let confirm = prompt(
    sprintf(
      button.dataset.warning,
      _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toUpperCase()
    )
  );

  if (
    !confirm ||
    confirm.toLowerCase() != _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toLowerCase()
  ) return;

  // Disable button
  _$$$('button-delete-my-account').setAttribute('disabled', true);

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_delete_my_account',
    'nonce': button.dataset.nonce,
    'id': button.dataset.id
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    if (response.success) {
      // Successfully deleted
      location.reload();
    } else {
      // Could not be deleted
      fcn_showNotification(response.data.error, 5, 'warning');
      _$$$('button-delete-my-account').innerHTML = response.data.button;
    }
  })
  .catch((error) => {
    if (error.status && error.statusText) {
      fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
      _$$$('button-delete-my-account').innerHTML = response.data.button;
    }
  });
}

// Listen for click on delete profile button
_$$$('button-delete-my-account')?.addEventListener(
  'click',
  e => {
    fcn_deleteMyAccount(e.currentTarget);
  }
);

// =============================================================================
// CLEAR DATA
// =============================================================================

const /** @const {DOMStringMap} */ fcn_profileDataTranslations = _$$$('profile-data-translations')?.dataset;

/**
 * Prompt with string submission before deletion of user data.
 *
 * @since 5.0
 * @param {HTMLElement} button - The clicked button.
 * @return {Boolean} True or false.
 */

function fcn_dataDeletionPrompt(button) {
  let confirm = prompt(
    sprintf(
      button.dataset.warning,
      _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toUpperCase()
    )
  );

  if (
    !confirm ||
    confirm.toLowerCase() != _x('delete', 'Prompt deletion confirmation string.', 'fictioneer').toLowerCase()
  ) return false;

  return true;
}

/**
 * AJAX request to clear specific data.
 *
 * @since 4.5
 * @param {HTMLElement} button - The clicked button.
 * @param {String} action - The action to perform.
 */

function fcn_clearData(button, action) {
  // Update view
  let card = button.closest('.card');

  // Clear web storage
  localStorage.removeItem('fcnBookshelfContent');

  // Indicator
  card.classList.add('ajax-in-progress');
  button.remove();

  // Payload
  let payload = {
    'action': action,
    'nonce': button.dataset.nonce
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    // Check for success
    if (response.success) {
      card.querySelector('.card__content').innerHTML = response.data.success;
    } else {
      fcn_showNotification(response.data.error, 10, 'warning');
    }
  })
  .catch((error) => {
    if (error.status && error.statusText) {
      fcn_showNotification(`${error.status}: ${error.statusText}`, 10, 'warning');
    }
  })
  .then(() => {
    card.classList.remove('ajax-in-progress');
  });
}

// Listen for click on clear comments button
_$('.button-clear-comments')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Clear data
    fcn_clearData(e.currentTarget, 'fictioneer_ajax_clear_my_comments');
  }
);

// Listen for click on clear comment subscriptions button
_$('.button-clear-comment-subscriptions')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Clear data
    fcn_clearData(e.currentTarget, 'fictioneer_ajax_clear_my_comment_subscriptions');
  }
);

// Listen for click on clear checkmarks button
_$('.button-clear-checkmarks')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Update local storage and view
    fcn_checkmarks = { 'data': {}, 'timestamp': Date.now() };
    fcn_updateCheckmarksView();

    // Clear data
    fcn_clearData(e.currentTarget, 'fictioneer_ajax_clear_my_checkmarks', true);
  }
);

// Listen for click on clear reminders button
_$('.button-clear-reminders')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Update local storage and view
    fcn_reminders = { 'data': {} };
    fcn_updateRemindersView();

    // Clear data
    fcn_clearData(e.currentTarget, 'fictioneer_ajax_clear_my_reminders', true);
  }
);

// Listen for click on clear follows button
_$('.button-clear-follows')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Update local storage and view
    fcn_follows = { 'data': {} };
    fcn_updateFollowsView();

    // Clear data
    fcn_clearData(e.currentTarget, 'fictioneer_ajax_clear_my_follows', true);
  }
);

// Listen for click on clear bookmarks button
_$('.button-clear-bookmarks')?.addEventListener(
  'click',
  e => {
    // Confirm clear request using localized string
    if (!fcn_dataDeletionPrompt(e.currentTarget)) return;

    // Remove bookmarks
    if (fcn_bookmarks.data) {
      Object.keys(fcn_bookmarks.data).forEach(id => fcn_removeBookmark(id));
    }

    // Update database and view
    e.currentTarget.closest('.card').querySelector('.card__content').innerHTML = fcn_profileDataTranslations.clearedSuccess;
    fcn_setBookmarks(fcn_bookmarks);
  }
);
