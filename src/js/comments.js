// =============================================================================
// THEME COMMENTS JS TRAP
// =============================================================================

/**
 * Append required field after the site has loaded.
 *
 * @description This prevents comment form submits from working if JavaScript
 * is not enabled, which is true for most bots. Yes, the value is just for
 * show and could be used better. A hashcash for example, to make spamming
 * really expensive!
 *
 * @since 5.0
 */

function fcn_addJSTrap() {
  // Setup
  let red = document.querySelector('.comment-form'); // Red makes it faster!

  // Add validation field to form
  if (red) {
    let input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.id = 'fictioneer-comment-validator';
    input.setAttribute('name', 'fictioneer_comment_validator');
    input.setAttribute('value', '299792458');
    red.appendChild(input);
  }
}

// Initialize
fcn_addJSTrap();

// =============================================================================
// THEME COMMENTS AJAX MODERATION
// =============================================================================

/**
 * Performs moderation action via AJAX.
 *
 * @description Takes the ID of a comment and calls the server function specified
 * by the operation string. Applies a successful result directly to the DOM
 * without reloading the page.
 *
 * @since 4.7
 * @param {Number} id - ID of the comment to be moderated.
 * @param {String} operation - The moderation action to perform. Choose between
 *   'Sticky', 'Unsticky', 'Approve', 'Unapprove', 'Open', 'Close', 'Trash', or 'Spam'.
 */

function fcn_moderateComment(id, operation) {
  // Setup
  let comment = _$$$(`comment-${id}`),
      menuToggle = comment.querySelector('.fictioneer-mod-menu-toggle');

  // Abort if another AJAX action is in progress
  if (comment.classList.contains('ajax-in-progress')) return;

  // Lock comment until AJAX action is complete
  comment.classList.add('ajax-in-progress');

  // Prepare comment for style transition
  if (operation == 'trash' || operation == 'spam') {
    comment.style.height = comment.clientHeight + 'px';
  }

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_moderate_comment',
    'operation': operation,
    'id': id
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    if (response.success) {
        // Server action succeeded
        switch (response.data.operation) {
          case 'sticky':
            comment.classList.add('_sticky');
            break;
          case 'unsticky':
            comment.classList.remove('_sticky');
            break;
          case 'approve':
            comment.classList.remove('_unapproved');
            break;
          case 'unapprove':
            comment.classList.add('_unapproved');
            break;
          case 'open':
            comment.classList.remove('_closed');
            break;
          case 'close':
            comment.classList.add('_closed');
            break;
          case 'trash':
          case 'spam':
            // Let comment collapse and fade to nothing
            menuToggle.onclick = '';
            comment.style.overflow = 'hidden';
            comment.style.height = '0';
            comment.style.margin = '0';
            comment.style.opacity = '0';
            break;
        }
      } else {
        // Server action failed, mark comment with alert
        menuToggle.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
        menuToggle.style.color = 'var(--warning)';
        menuToggle.style.opacity = '1';
        menuToggle.onclick = '';

        if (response.data.error) {
          fcn_showNotification(response.data.error, 5, 'warning');
        }
      }
  })
  .catch((error) => {
    // Server action failed, mark comment with alert
    menuToggle.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
    menuToggle.style.color = 'var(--warning)';
    menuToggle.style.opacity = '1';
    menuToggle.onclick = '';

    if (error.status && error.statusText) {
      fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
    }
  })
  .then(() => {
    // Remove progress state
    comment.classList.remove('ajax-in-progress');
  });
}

/**
 * Listen to clicks on moderation menu toggle.
 *
 * @since 5.0
 * @param {HTMLElement=} node - The node to query through. Defaults to document.
 */

function fcn_addModerationMenuEvents(node = document) {
  node.querySelectorAll('.toggle-last-clicked').forEach(element => {
    element.addEventListener(
      'click',
      e => {
        fcn_toggleLastClicked(e.currentTarget);
        e.stopPropagation();
      }
    );
  });
}

/**
 * Listen to clicks on moderation action.
 *
 * @since 4.7
 */

function fcn_addModerationEvents() {
  _$$('.button-ajax-moderate-comment').forEach(element => {
    element.addEventListener(
      'click',
      e => {
        fcn_moderateComment(
          e.currentTarget.dataset.id,
          e.currentTarget.dataset.action
        );
      }
    );
  });
}

fcn_addModerationEvents();

/**
 * Listen to mouseleave to close the moderation menu.
 *
 * @since 4.7
 */

function fcn_addCommentMouseleaveEvents() {
  _$$('.fictioneer-comment__container').forEach(element => {
    element.addEventListener(
      'mouseleave',
      e => {
        if ( fcn_lastClicked ) fcn_lastClicked.classList.remove('last-clicked');
        fcn_lastClicked = null;
        e.stopPropagation();
      }
    );
  });
}

fcn_addCommentMouseleaveEvents();

// =============================================================================
// THEME COMMENTS AJAX REPORTING
// =============================================================================

/**
 * Report a comment via AJAX.
 *
 * @since 4.7
 * @param {Number} id - ID of the comment to be moderated.
 */

function fcn_flagComment(source) {
  // Only if user is logged in
  if (!fcn_isLoggedIn) return;

  // Setup
  let comment = source.closest('.fictioneer-comment'),
      reportButton = comment.querySelector('.fictioneer-report-comment-button');

  // Abort if another AJAX action is in progress
  if (comment.classList.contains('ajax-in-progress')) return;

  // Lock comment until AJAX action is complete
  comment.classList.add('ajax-in-progress');

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_report_comment',
    'id': comment.dataset.id,
    'dubious': reportButton.classList.contains('_dubious')
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    // Comment successfully reported?
    if (response.success) {
      reportButton.classList.toggle('on', response.data.flagged);
      reportButton.classList.remove('_dubious');

      // If report was dubious, it will be resynchronized
      if (response.data.resync) fcn_showNotification(response.data.resync);
    } else {
      // Show error notice
      if (response.data?.error) fcn_showNotification(response.data.error, 5, 'warning');
    }
  })
  .catch((error) => {
    // Show server error
    if (error.status && error.statusText) {
      fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
    }
  })
  .then(() => {
    // Regardless of success
    comment.classList.remove('ajax-in-progress');
  });
}

// =============================================================================
// THEME COMMENTS RESPONSE
// =============================================================================

/**
 * Adjust textarea height to fit the value without vertical scroll bar.
 *
 * @since 4.7
 * @param {HTMLElement} area - The textarea element to adjust.
 */

function fcn_textareaAdjust(area) {
  area.style.height = 'auto'; // Reset if lines are removed
  area.style.height = area.scrollHeight + 'px';
}

/**
 * Listen for input on adaptive textareas.
 *
 * @since 4.7
 */

function fcn_addTextareaEvents() {
  _$$('.adaptive-textarea').forEach(element => {
    element.addEventListener(
      'input',
      e => {
        fcn_textareaAdjust(e.currentTarget);
      }
    );
  });
}

fcn_addTextareaEvents();

/**
 * Listen for changes of the private toggle.
 *
 * @since 5.0
 */

function fcn_addPrivateToggleEvents() {
  _$$$('fictioneer-private-comment-toggle')?.addEventListener(
    'change',
    e => {
      _$$$('respond')?.classList.toggle('_private', e.currentTarget.checked);
    }
  );
}

fcn_addPrivateToggleEvents();

// =============================================================================
// THEME COMMENTS FORMATTING BUTTONS
// =============================================================================

/**
 * Wrap a text selection within an editable element in tags.
 *
 * @since 4.7
 * @param {HTMLElement} element - The editable element with the selection.
 * @param {String} tag - The tag to be used.
 * @param {String[]=} Options - Options defined as strings.
 */

function fcn_wrapInTag(element, tag, options = {}) {
  let href = options.href ? ' href="' + options.href + '" target="_blank" rel="nofollow noreferrer noopener"' : '',
      brackets = options.shortcode ? ['[', ']'] : ['<', '>'],
      start = element.selectionStart,
      end = element.selectionEnd,
      open = brackets[0] + tag + href + brackets[1],
      close = brackets[0] + '/' + tag + brackets[1],
      text = open + element.value.substring(start, end) + close;

  element.value = element.value.substring(0, start) + text + element.value.substring(end, element.value.length);
  element.setSelectionRange((start + open.length), (end + open.length));
  element.focus();
}

/**
 * Wrap text selection into [b] shortcode.
 *
 * @since 4.7
 */

function fcn_commentMakeBold() {
  fcn_wrapInTag(_$$$('comment'), 'b', {'shortcode': true});
}

/**
 * Wrap text selection into [i] shortcode.
 *
 * @since 4.7
 */

function fcn_commentMakeItalic() {
  fcn_wrapInTag(_$$$('comment'), 'i', {'shortcode': true});
}

/**
 * Wrap text selection into [s] shortcode.
 *
 * @since 4.7
 */

function fcn_commentMakeStrike() {
  fcn_wrapInTag(_$$$('comment'), 's', {'shortcode': true});
}

/**
 * Wrap text selection into [link] shortcode.
 *
 * @since 4.7
 */

function fcn_commentMakeLink() {
  fcn_wrapInTag(_$$$('comment'), 'link', {'shortcode': true});
}

/**
 * Wrap text selection into [quote] shortcode.
 *
 * @since 5.0
 */

function fcn_commentMakeQuote() {
  fcn_wrapInTag(_$$$('comment'), 'quote', {'shortcode': true});
}

/**
 * Wrap text selection into [spoiler] shortcode.
 *
 * @since 4.7
 */

function fcn_commentMakeSpoiler() {
  fcn_wrapInTag(_$$$('comment'), 'spoiler', {'shortcode': true});
}

/**
 * Wrap text selection into [img] shortcode.
 *
 * @since 5.0
 */

function fcn_commentMakeImage() {
  fcn_wrapInTag(_$$$('comment'), 'img', {'shortcode': true});
}

// =============================================================================
// AJAX COMMENT SUBMISSION
// =============================================================================

/**
 * Bind AJAX request to comment form submit and override default behavior.
 *
 * @since 5.0
 */

function fcn_bindAJAXCommentSubmit() {
  // Check whether AJAX submit is enabled, abort if not...
  if (!fcn_theRoot.dataset.ajaxSubmit || fcn_theRoot.dataset.ajaxSubmit != 'true') {
    return;
  }

  // Override form submit behavior
  _$$$('commentform')?.addEventListener('submit', (e) => {
    // Stop default form submission
    e.preventDefault();

    // Delay trap (cannot be done server-side because of caching)
    if (Date.now() < fcn_pageLoadTimestamp + 3000) return;

    // Get comment form input
    let form = e.currentTarget,
        button = _$$$('submit'),
        content = _$$$('comment'),
        author = _$$$('author'),
        email = _$$$('email'),
        cookie_consent = _$$$('wp-comment-cookies-consent'),
        privacy_consent = _$$$('fictioneer-privacy-policy-consent'),
        jsValidator = _$$$('fictioneer-comment-validator'),
        parentId = _$$$('comment_parent').value,
        parent = _$$$(`comment-${parentId}`),
        private_comment = _$$$('fictioneer-private-comment-toggle'),
        notification = _$$$('fictioneer-comment-notification-toggle'),
        emailValidation = true,
        contentValidation = true,
        privacyValidation = true;

    // Validate content
    contentValidation = content.value.length > 1;
    content.classList.toggle('_error', !contentValidation);

    // Validate privacy policy checkbox
    if (privacy_consent) privacyValidation = privacy_consent.checked;
    privacy_consent?.classList.toggle('_error', !privacyValidation);

    // Validate email address pattern (better validation server-side)
    if (email && email.value.length > 0) emailValidation = /\S+@\S+\.\S+/.test(email.value);
    email?.classList.toggle('_error', !emailValidation);

    // Abort if...
    if (!contentValidation || !privacyValidation || !emailValidation) return false;

    // Disable form during submit
    form.classList.add('ajax-in-progress');
    button.disabled = true;
    button.value = button.dataset.disabled;

    // Payload
    let payload = {
      'action': 'fictioneer_ajax_submit_comment',
      'post_id': _$$$('comment_post_ID').value,
      'content': content.value,
      'private_comment': private_comment?.checked ?? 0,
      'notification': notification?.checked ?? 0,
      'cookie_consent': cookie_consent?.checked ?? 0,
      'privacy_consent': privacy_consent?.checked ?? 0,
      'unfiltered_html': _$$$('_wp_unfiltered_html_comment_disabled')?.value ?? '',
      'depth': parent ? parseInt(parent.dataset.depth) + 1 : 1,
      'fictioneer_comment_validator': jsValidator?.value ?? 0
    }

    // Optional payload
    if (parentId) payload['parent_id'] = parentId;
    if (email?.value) payload['email'] = email?.value;
    if (author?.value) payload['author'] = author?.value;

    // Request
    fcn_ajaxPost(payload)
    .then((response) => {
      // Remove previous error notices (if any)
      _$$$('comment-submit-error-notice')?.remove();

      // Comment successfully saved?
      if (!response.success || !response.data?.comment) {
        // Add error message
        let errorNote = response.data?.error ?? __('Error', 'fictioneer');
        form.insertBefore(fcn_buildErrorNotice(errorNote, 'comment-submit-error-notice'), form.firstChild);
      } else {
        // Insert new comment
        let target = _$('.commentlist'),
            insertMode = 'insertBefore';

        // Account for sticky comments
        if (target && !parent && target.firstElementChild) {
          let maybeSticky = null;

          if (target.firstElementChild.classList.contains('_sticky')) {
            maybeSticky = target.firstElementChild;
            target = maybeSticky;
            insertMode = 'insertAfter';

            while (maybeSticky.nextElementSibling && maybeSticky.nextElementSibling.classList.contains('_sticky')) {
              maybeSticky = target.nextElementSibling;
              target = maybeSticky;
            }
          }
        }

        // Create list if missing
        if (!target) {
          // First comment, list missing!
          let list = document.createElement('ol');
          list.classList = 'fictioneer-comments__list commentlist';
          _$$$('comments').appendChild(list);
          insertMode = 'append';
          target = list;
        }

        // Account for parent of reply
        if (parent) {
          // Get child comment list
          target = parent.querySelector('.children');

          // Append in this case
          insertMode = 'append';

          // Create child comment list if missing
          if (!target) {
            let node = document.createElement('ol');
            parent.appendChild(node);
            target = node;
          }
        }

        let commentNode = document.createElement('div');
        commentNode.innerHTML = response.data.comment;
        commentNode = commentNode.firstChild;

        switch (insertMode) {
          case 'append':
            target.appendChild(commentNode);
            break;
          case 'insertBefore':
            target.insertBefore(commentNode, target.firstChild);
            break;
          case 'insertAfter':
            if (target.nextSibling) {
              target.parentNode.insertBefore(commentNode, target.nextSibling);
            } else {
              target.parentNode.appendChild(commentNode);
            }
        }

        // Bind events
        fcn_addModerationMenuEvents(commentNode);
        fcn_addModerationEvents();
        fcn_addCommentMouseleaveEvents();

        // Clean-up form
        if (_$$$('comment_parent').value != '0') _$$$('cancel-comment-reply-link').click();
        content.value = '';
        content.style.height = '';

        // Update URL
        let refresh = window.location.protocol + '//' + window.location.host + window.location.pathname,
            urlPart = '';

        if (response.data.commentcode) urlPart += `?commentcode=${response.data.commentcode}`;

        history.pushState({ path: refresh }, '', refresh + urlPart + `#comment-${response.data.comment_id}`);

        // Scroll to new comment
        commentNode.scrollIntoView({behavior: 'smooth'});
      }
    })
    .catch((error) => {
      // Remove any old error
      _$$$('comment-submit-error-notice')?.remove();

      // Add error message
      form.insertBefore(
        fcn_buildErrorNotice(`${error.status}: ${error.statusText}`, 'comment-submit-error-notice'),
        form.firstChild
      );
    })
    .then(() => {
      // Remove progress state
      form.classList.remove('ajax-in-progress');

      // Re-enable the submit button
      button.disabled = false;
      button.value = button.dataset.enabled;
    });
  });
}

// Initialize AJAX submit (if enabled)
fcn_bindAJAXCommentSubmit();

// =============================================================================
// AJAX INLINE COMMENT EDIT
// =============================================================================

var /** @type {Object} */ fcn_commentEditUndos = {};

/**
 * Trigger inline comment edit.
 *
 * @description This is called with on inline onclick event handler because the
 * comments can be loaded via AJAX and constantly watching the DOM to rebind the
 * event listeners is unreasonable. All that extra code, all the extra work for
 * the system, for something that you can get at no cost. Seriously.
 *
 * @since 5.0
 * @param {HTMLElement} source - Event source.
 */

function fcn_triggerInlineCommentEdit(source) {
  // Setup
  let red = source.closest('.fictioneer-comment'); // Red makes it faster!

  // Main comment container found...
  if (red) {
    let content = red.querySelector('.fictioneer-comment__content'),
        edit = red.querySelector('.fictioneer-comment__edit'),
        textarea = red.querySelector('.comment-inline-edit-content');

    // Save unedited content
    fcn_commentEditUndos[red.id] = textarea.value;

    // Set comment edit state
    red.classList.add('_editing');
    content.hidden = true;
    edit.hidden = false;
    textarea.style.height = textarea.scrollHeight + 'px';
  }
}

/**
 * Submit inline comment edit via AJAX
 *
 * @since 5.0
 * @param {HTMLElement} source - Event source.
 */

function fcn_submitInlineCommentEdit(source) {
  // Setup
  let red = source.closest('.fictioneer-comment'), // Red makes it faster!
      edit = red.querySelector('.fictioneer-comment__edit'),
      editNote = red.querySelector('.fictioneer-comment__edit-note'),
      content = red.querySelector('.comment-inline-edit-content').value;

  // Abort if...
  if (content == fcn_commentEditUndos[red.id]) {
    fcn_restoreComment(red, true);
    return;
  }

  // Send update
  if (red) {
    let payload = {
      'action': 'fictioneer_ajax_edit_comment',
      'comment_id': red.id.replace('comment-', ''),
      'content': content
    }

    // Disable edit form
    edit.classList.add('ajax-in-progress');
    source.innerHTML = source.dataset.disabled;
    source.disabled = true;

    // Request
    fcn_ajaxPost(payload)
    .then(response => {
      // Comment successfully updated?
      if (response.success) {
        // Replace content in view and restore non-edit state
        let content = red.querySelector('.fictioneer-comment__content');
        content.innerHTML = response.data.content;
        fcn_restoreComment(red, false, response.data.raw);

        // Edit note
        if (!editNote) editNote = document.createElement('div');
        editNote.classList.add('fictioneer-comment__edit-note');
        editNote.innerHTML = response.data.edited;
        content.parentNode.appendChild(editNote);
      } else {
        // Restore non-edit state
        fcn_restoreComment(red, true);

        // Show error notice
        if (response.data?.error) fcn_showNotification(response.data.error, 5, 'warning');
      }
    })
    .catch((error) => {
      // Restore non-edit state
      fcn_restoreComment(red, true);

      // Show server error
      if (error.status && error.statusText) {
        fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
      }
    })
    .then(() => {
      // Regardless of result
      edit.classList.remove('ajax-in-progress');
      source.innerHTML = source.dataset.enabled;
      source.disabled = false;
    });
  }
}

/**
 * Cancel inline comment edit.
 *
 * @since 5.0
 * @param {HTMLElement} source - Event source.
 */

function fcn_cancelInlineCommentEdit(source) {
  // Setup
  let red = source.closest('.fictioneer-comment'); // Red makes it faster!

  // Restore comment to non-edit state
  if (red) fcn_restoreComment(red, true);
}

/**
 * Restore comment to non-editing state.
 *
 * @since 5.0
 * @param {HTMLElement} target - The comment to restore.
 */

function fcn_restoreComment(target, undo = false, update = null) {
  target.querySelector('.fictioneer-comment__content').hidden = false;
  target.querySelector('.fictioneer-comment__edit').hidden = true;
  target.classList.remove('_editing');
  if (undo && fcn_commentEditUndos[target.id]) {
    target.querySelector('.comment-inline-edit-content').value = fcn_commentEditUndos[target.id];
  } else if (update) {
    target.querySelector('.comment-inline-edit-content').value = update;
  }
}

// =============================================================================
// SHOW EDIT BUTTON BASED ON FINGERPRINT
// =============================================================================

/**
 * Reveal edit buttons that match the user's fingerprint
 *
 * @since 5.0
 */

function fcn_revealEditButton() {
  // Get time limit for editing
  let editTime = parseInt(fcn_theRoot.dataset.editTime);

  // Abort if no time set
  if (!editTime) return;

  // Prepare comparison
  editTime = editTime > 0 ? editTime * 60000 : editTime;

  // Loop over comments with matching fingerprint (if any)
  _$$('.fictioneer-comment[data-fingerprint]').forEach(element => {
    if (fcn_matchFingerprint(element.dataset.fingerprint)) {
      // -1 means no time limit
      if (editTime > 0 && parseInt(element.dataset.timestamp) + editTime < Date.now()) {
        return;
      }

      // Reveal button
      let button = element.querySelector('.fictioneer-comment__edit-toggle');
      if (button) button.hidden = false;
    }
  });
}

// Reveal edit buttons
if (fcn_isLoggedIn) fcn_revealEditButton();

// =============================================================================
// SHOW DELETE BUTTON BASED ON FINGERPRINT
// =============================================================================

/**
 * Reveal delete buttons that match the user's fingerprint
 *
 * @since 5.0
 */

function fcn_revealDeleteButton() {
  // Loop over comments with matching fingerprint (if any)
  _$$('.fictioneer-comment[data-fingerprint]').forEach(element => {
    if (fcn_matchFingerprint(element.dataset.fingerprint)) {
      // Reveal button
      let button = element.querySelector('.fictioneer-comment__delete');
      if (button) button.hidden = false;
    }
  });
}

// Reveal edit buttons
if (fcn_isLoggedIn) fcn_revealDeleteButton();

// =============================================================================
// AJAX USER COMMENT DELETE
// =============================================================================

/**
 * Soft-delete comment on user request
 *
 * @since 5.0
 * @param {HTMLElement} button - The clicked delete button.
 */

function fcn_deleteMyComment(button) {
  // Only if user is logged in
  if (!fcn_isLoggedIn) return;

  // Prompt for confirmation
  let confirm = prompt(button.dataset.dialogMessage);

  if (!confirm || confirm.toLowerCase() != button.dataset.dialogConfirm.toLowerCase()) {
    return;
  }

  // Setup
  let comment = button.closest('.fictioneer-comment');

  // Abort if another AJAX action is in progress
  if (comment.classList.contains('ajax-in-progress')) return;

  // Lock comment until AJAX action is complete
  comment.classList.add('ajax-in-progress');

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_delete_my_comment',
    'comment_id': comment.dataset.id
  }

  // Request
  fcn_ajaxPost(payload)
  .then((response) => {
    if (response.success) {
      comment.classList.add('_deleted');
      comment.querySelector('.fictioneer-comment__container').innerHTML = response.data.html;
    } else {
      if (response.data.error) {
        fcn_showNotification(response.data.error, 5, 'warning');
      }
    }
  })
  .catch((error) => {
    if (error.status && error.statusText) {
      fcn_showNotification(`${error.status}: ${error.statusText}`, 5, 'warning');
    }
  })
  .then(() => {
    // Update view regardless of success
    comment.classList.remove('ajax-in-progress');
  });
}

// =============================================================================
// REQUEST COMMENTS FORM VIA AJAX
// =============================================================================

const /** @const {HTMLElement} */ fcn_ajaxCommentForm = _$$$('ajax-comment-form-target');

// Check whether form target exists...
if (fcn_ajaxCommentForm) {
  // Check for nonce deferment...
  if (fcn_theRoot.dataset.ajaxNonce && !_$$$('fictioneer-ajax-nonce')) {
    // Load after nonce has been fetched
    fcn_theRoot.addEventListener('nonceReady', () => {
      fcn_getCommentForm();
    });
  } else {
    // Load as soon as possible
    fcn_getCommentForm();
  }
}

/**
 * Load comment form via AJAX.
 *
 * @since 5.0
 */

function fcn_getCommentForm() {
  // Setup
  let errorNote;

  // Payload
  let payload = {
    'action': 'fictioneer_ajax_get_comment_form',
    'post_id': _$$$('comments').dataset.postId
  }

  // Request
  fcn_ajaxGet(payload)
  .then((response) => {
    if (response.success) {
      // Get HTML
      let temp = document.createElement('div');
      temp.innerHTML = response.data.html;

      // Get form elements
      let commentPostId = temp.querySelector('#comment_post_ID'),
          cancelReplyLink = temp.querySelector('#cancel-comment-reply-link'),
          logoutLink = temp.querySelector('.logout-link');

      // Fix form elements
      if (commentPostId) commentPostId.value = response.data.postId;
      if (cancelReplyLink) cancelReplyLink.href = "#respond";
      if (logoutLink) logoutLink.href = _$$$('comments').dataset.logoutUrl;

      // Output HTML
      fcn_ajaxCommentForm.innerHTML = temp.innerHTML;
      temp.remove();

      // Bind events
      fcn_addTextareaEvents();
      fcn_addPrivateToggleEvents()
      if (fcn_theRoot.dataset.ajaxSubmit) fcn_bindAJAXCommentSubmit();

      // JS trap (if active)
      fcn_addJSTrap();
    } else {
      errorNote = fcn_buildErrorNotice(response.data.error);
    }
  })
  .catch((error) => {
    errorNote = fcn_buildErrorNotice(error);
  })
  .then(() => {
    // Update view regardless of success
    fcn_ajaxCommentForm.classList.remove('comments-skeleton');

    // Add error (if any)
    if (errorNote) {
      fcn_ajaxCommentForm.innerHTML = '';
      fcn_ajaxCommentForm.appendChild(errorNote);
    }
  });
}
