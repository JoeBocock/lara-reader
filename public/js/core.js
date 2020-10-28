// Register listener for visibility of the form
document
    .getElementById('add-feed')
    .addEventListener('click', handleFormVisibility);

// Register the submission of a form
document
    .getElementById('rss-form')
    .addEventListener('submit', submitRSSFeed);

// Register onclick for the button visibility
document.addEventListener('click', handleLinkButton);

/**
 * Post a value to an endpoint.
 *
 * @param {string} url endpoint
 * @param {object} data post data
 */
async function post(url = '', data = {}) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        body: JSON.stringify(data),
    });

    return response.json();
}

/**
 * Handle form visibility on the page.
 */
function handleFormVisibility() {
    let form = document.getElementById('rss-form');

    if (form.style.display === '' || form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

/**
 * Submit an RSS Feed URL and handle the response.
 *
 * @param {Event} event
 */
function submitRSSFeed(event) {
    event.preventDefault();

    post('/api/feed', {
        url: document.getElementById('url').value,
    }).then((response) => {
        if (response.errors) {
            handleError(response.errors);
        } else {
            handleSuccess();
        }
    });
}

/**
 * Display the first error in the stack.
 *
 * @param {object} errors
 */
function handleError(errors) {
    document.getElementById('form-error').children[0].innerHTML = errors['url'][0];
}

/**
 * Upon success, reload page.
 *
 * I couldn't normally resort to this as a method to
 * re-populate the page but in the interest of time
 * this is what I went with.
 */
function handleSuccess() {
    location.reload();
}


/********* Button Related JS *********/

/**
 * Current active element with a visible button.
 */
let activeElement = '';

/**
 * Handle the visibility of a link button.
 *
 * @param {Event} event
 */
function handleLinkButton(event) {
    if (activeElement !== event.target) {
        wipeButtons();
    }

    if (event.altKey && event.target.querySelector('.card-button') && elementHadValidClass(event)) {
        event.target.querySelector('.card-button').style.display = 'inline-flex';
        activeElement = event.target;
    }
}

/**
 * Wipe any and all buttons from the screen.
 */
function wipeButtons() {
    Array.from(document.getElementsByClassName('card-button')).forEach((element) => {
        element.style.display = 'none';
    });
}

/**
 * Check if the event has a valid class on element.
 *
 * @param {Event} event
 */
function elementHadValidClass(event) {
    let classList = Array.from(event.target.classList);

    return (classList.includes('description-container') || classList.includes('terminal-alert'));
}
