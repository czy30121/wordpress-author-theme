// =============================================================================
// SETUP
// =============================================================================

const /** @const {HTMLElement} */ fcn_ajaxCommentsSection = _$$$('comments');

var /** @type {String[]} */ fcn_commentStack = [];

// =============================================================================
// REQUEST COMMENTS SECTION VIA AJAX
// =============================================================================

/**
 * Load comment section via AJAX.
 *
 * @since 5.0
 * @param {Number=} post_id - The current post ID.
 * @param {Number=} page - The requested page number.
 */

function fcn_getCommentSection(post_id = null, page = null, scroll = false) {
  //Abort conditions...
  if (!fcn_ajaxCommentsSection) return;

  // Setup
  const commentSection = _$$$('comments');
  let commentText = '',
      comment = _$$$('comment'),
      errorNote;

  // Preserve comment text (if any)
  if (comment) commentText = comment.value;

  // Abort if another AJAX action is in progress
  if (fcn_ajaxCommentsSection.classList.contains('ajax-in-progress')) return;

  // Lock comment until AJAX action is complete
  fcn_ajaxCommentsSection.classList.add('ajax-in-progress');

  // Get page
  if (!page) page = fcn_urlParams.pg ?? 1;

  // Abort if Fictioneer comment section not found
  if (!fcn_ajaxCommentsSection) return;

  // Payload
  const payload = {
    'action': 'fictioneer_ajax_get_comment_section',
    'post_id': post_id ?? fcn_ajaxCommentsSection.dataset.postId,
    'page': page
  }

  if (fcn_urlParams.commentcode) payload['commentcode'] = fcn_urlParams.commentcode;

  // Request
  fcn_ajaxGet(payload)
  .then((response) => {
    // Check for success
    if (response.success) {
      // Update page
      page = response.data.page;

      // Get HTML
      const temp = document.createElement('div');
      temp.innerHTML = response.data.html;

      // Fix comment form
      if (temp.querySelector('#comment_post_ID')) {
        temp.querySelector('#comment_post_ID').value = response.data.postId;
        temp.querySelector('#cancel-comment-reply-link').href = "#respond";

        const logoutLink = temp.querySelector('.logout-link');
        if (logoutLink) logoutLink.href = _$$$('comments').dataset.logoutUrl;
      }

      // Output HTML
      commentSection.innerHTML = temp.innerHTML;
      temp.remove();

      // Restore comment text (if any)
      comment = _$$$('comment');
      if (comment) comment.value = commentText;

      // Append stack contents
      if (comment) {
        fcn_commentStack.forEach(node => {
          comment.value += node;
        });
      }

      fcn_commentStack = [];

      // Resize comment textarea if necessary
      if (comment) fcn_textareaAdjust(comment);

      // Bind events
      fcn_addModerationEvents();
      fcn_addCommentMouseleaveEvents();
      fcn_addTextareaEvents();
      fcn_addCommentFormEvents();
      fcn_addPrivateToggleEvents()
      fcn_bindAJAXCommentSubmit();

      // JS trap (if active)
      fcn_addJSTrap();

      // Reveal edit buttons
      fcn_revealEditButton();

      // Scroll to top of comment section
      const scrollTargetSelector = location.hash.includes('#comment') ? location.hash : '.respond',
            scrollTarget = document.querySelector(scrollTargetSelector) ?? _$$$('respond');
      if (scroll) scrollTarget.scrollIntoView({behavior: 'smooth'});

      // Add page to URL and preserve params/anchor
      const refresh = window.location.protocol + '//' + window.location.host + window.location.pathname;
      let urlPart = '';

      if (fcn_urlParams.commentcode) urlPart += `?commentcode=${fcn_urlParams.commentcode}`;

      if (page > 1) urlPart += urlPart.length > 1 ? `&pg=${page}` : `?pg=${page}`;

      window.history.pushState({ path: refresh }, '', refresh + urlPart + location.hash);
    } else {
      errorNote = fcn_buildErrorNotice(response.data.error);
    }
  })
  .catch((error) => {
    errorNote = fcn_buildErrorNotice(error);
  })
  .then(() => {
    // Update view regardless of success
    fcn_ajaxCommentsSection.classList.remove('ajax-in-progress');

    // Add error (if any)
    if (errorNote) {
      commentSection.innerHTML = '';
      commentSection.appendChild(errorNote);
    }
  });
}

/**
 * Wrapper to reload the comments section with only the page number
 * as parameter and scroll set to true.
 *
 * @since 5.0
 * @param {Number=} page - The requested page number.
 */

function fcn_reloadCommentsPage(page = null) {
  fcn_getCommentSection(null, page, true);
}

function fcn_jumpToCommentPage() {
  // Prompt user to enter desired page number
  const input = parseInt(window.prompt(_x('Enter page number:', 'Pagination jump prompt.', 'fictioneer')));

  // Reload comments on entered page
  if (input > 0) fcn_reloadCommentsPage(input);
}

// =============================================================================
// COMMENTS OBSERVER
// =============================================================================

var /** @type {IntersectionObserver} */ fct_commentsObserver;

// In case of nonce deferment
if (fcn_theRoot.dataset.ajaxNonce && !_$$$('fictioneer-ajax-nonce')) {
  fcn_theRoot.addEventListener('nonceReady', () => {
    fcn_setupCommentObserver();
  });
} else {
  fcn_setupCommentObserver();
}

/**
 * Helper to set up comments observer.
 *
 * @since 5.0
 */

function fcn_setupCommentObserver() {
  fct_commentsObserver = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) {
        fcn_getCommentSection();
        fct_commentsObserver.disconnect();
      }
    },
    { rootMargin: '400px', threshold: 1 }
  );

  // Observer comment section and fire AJAX request once
  if (fcn_ajaxCommentsSection) fct_commentsObserver.observe(fcn_ajaxCommentsSection);
}

// =============================================================================
// SCROLL NEW COMMENT INTO VIEW SUBMITTING VIA RELOAD
// =============================================================================

// In case of nonce deferment
if (fcn_theRoot.dataset.ajaxNonce && !_$$$('fictioneer-ajax-nonce')) {
  fcn_theRoot.addEventListener('nonceReady', () => {
    fcn_loadCommentEarly();
  });
} else {
  fcn_loadCommentEarly();
}

/**
 * Load comment section early if there is a comment* anchor.
 *
 * @since 5.0
 */

function fcn_loadCommentEarly() {
  // Check URL whether there is a comment anchor
  if (_$$$('comments') && location.hash.includes('#comment')) {
    // Start loading comments via AJAX if not done already
    if (!_$$$('comment')) {
      fct_commentsObserver.disconnect();
      fcn_reloadCommentsPage();
    }
  }
}
