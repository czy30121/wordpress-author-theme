// =============================================================================
// SETUP
// =============================================================================

var /** @type {Number} */ fcn_storyCommentPage = 1;

// Initialize
var /** @type {Object} */ fcn_storySettings = fcn_getStorySettings();

// =============================================================================
// LOAD USER SETTINGS
// =============================================================================

/**
 * Get story settings JSON from local storage or create new one.
 *
 * @since 5.0.6
 * @see fcn_isValidJSONString()
 * @see fcn_defaultStorySettings()
 * @see fcn_setStorySettings();
 * @return {Object} The story settings.
 */

function fcn_getStorySettings() {
  // Look in local storage...
  let settings = localStorage.getItem('fcnStorySettings');

  // ... parse if found, set defaults otherwise
  settings = (settings && fcn_isValidJSONString(settings)) ? JSON.parse(settings) : fcn_defaultStorySettings();

  // Timestamp allows to force resets after script updates (may annoy users)
  if (!settings.hasOwnProperty('timestamp') || settings['timestamp'] < 1674770712849) {
    settings = fcn_defaultStorySettings();
    settings['timestamp'] = Date.now();
  }

  // Update local storage and return
  fcn_setStorySettings(settings);
  return settings;
}

/**
 * Returns default story settings.
 *
 * @since 5.0.6
 * @return {Object} The formatting settings.
 */

function fcn_defaultStorySettings() {
  return {
    'view': 'list',
    'order': 'asc',
    'timestamp': 1674770712849 // Used to force resets on script updates
  };
}

/**
 * Set the story settings object and save to local storage.
 *
 * @since 5.0.6
 * @param {Object} settings - The formatting settings.
 */

function fcn_setStorySettings(settings) {
  // Simple validation
  if (typeof settings !== 'object') return;

  // Keep global updated
  fcn_storySettings = settings;

  // Update local storage
  localStorage.setItem('fcnStorySettings', JSON.stringify(settings));
}

/**
 * Apply story settings
 *
 * @since 5.0.6
 */

function fcn_applyStorySettings() {
  // Simple validation
  if (typeof fcn_storySettings !== 'object') return;

  // List view
  _$$('[data-view]').forEach(element => {
    element.dataset.view = fcn_storySettings.view == 'grid' ? 'grid' : 'list';
  });

  // List order
  _$$('[data-order]').forEach(element => {
    element.dataset.order = fcn_storySettings.order == 'desc' ? 'desc' : 'asc';
  });
}

// Initialize
fcn_applyStorySettings();

// =============================================================================
// ORDER & VIEW
// =============================================================================

// Event listener for to toggle chapter order
_$$$('button-toggle-chapter-order')?.addEventListener(
  'click',
  e => {
    fcn_storySettings['order'] = e.currentTarget.dataset.order === 'asc' ? 'desc' : 'asc';
    fcn_setStorySettings(fcn_storySettings);
    fcn_applyStorySettings();
  }
);

// Event listener for to toggle chapter view
_$$$('button-toggle-chapter-view')?.addEventListener(
  'click',
  e => {
    fcn_storySettings['view'] = e.currentTarget.dataset.view === 'list' ? 'grid' : 'list';
    fcn_setStorySettings(fcn_storySettings);
    fcn_applyStorySettings();
  }
);

// =============================================================================
// CHAPTER FOLDING
// =============================================================================

_$$('.chapter-group__folding-toggle').forEach(element => {
  element.addEventListener(
    'click',
    e => {
      const group = e.currentTarget.closest('.chapter-group[data-folded]');

      if (group) {
        group.dataset.folded = group.dataset.folded == 'true' ? 'false' : 'true';
      }
    }
  );
});

// =============================================================================
// STORY TABS
// =============================================================================

/**
 * Toggles the active story tab
 *
 * @since 5.4.0
 *
 * @param {HTMLElement} target - The clicked tab element.
 */

function fcn_toggleStoryTab(target) {
  // Clear previous tab
  _$$('.story__article  ._current').forEach(item => {
    item.classList.remove('_current');
  });

  // Set new tab
  _$$$(target.dataset.target).classList.add('_current');
  _$$$('tabs').dataset.current = target.dataset.target;
  target.classList.add('_current');
}

// Listen for clicks on tabs...
_$$('.tabs__item').forEach(element => {
  element.addEventListener(
    'click',
    event => {
      fcn_toggleStoryTab(event.currentTarget);
    }
  );
});

// =============================================================================
// LOAD STORY COMMENTS
// =============================================================================

/**
 * Fetch and insert the HTML for the next batch of comments on the story page.
 *
 * @since 4.0
 */

function fcn_loadStoryComments() {
  // Setup
  let errorNote;

  // Prepare view
  _$('.load-more-list-item').remove();
  _$('.comments-loading-placeholder').classList.remove('hidden');

  // Request
  fcn_ajaxGet({
    'action': 'fictioneer_request_story_comments',
    'post_id': fcn_inlineStorage.postId,
    'page': fcn_storyCommentPage
  })
  .then((response) => {
    // Check for success
    if (response.success) {
      _$('.fictioneer-comments__list > ul').innerHTML += response.data.html;
      fcn_storyCommentPage++;
    } else if (response.data?.error) {
      errorNote = fcn_buildErrorNotice(response.data.error);
    }
  })
  .catch((error) => {
    errorNote = fcn_buildErrorNotice(error);
  })
  .then(() => {
    // Remove progress state
    _$('.comments-loading-placeholder').remove();

    // Add error if any
    if (errorNote) _$('.fictioneer-comments__list > ul').appendChild(errorNote);
  });
}
