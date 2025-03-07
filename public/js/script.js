
document.addEventListener('DOMContentLoaded', () => {
    //banner search
    const suggestions = document.querySelectorAll('.custom-radio-btn');
    const formSearch = document.getElementById('form-search');

    let url = new URL(window.location.href);
    url.href = window.location.href + 'jobs';
    let suggestion = '';
    suggestions.forEach(item => {
        item.addEventListener('change', (event) => {
            if (event.target.checked) {
                suggestion = item.value;
            }
        })
    })


    if (formSearch) {
        formSearch.addEventListener('submit', (event) => {
            event.preventDefault();


            const keyword = event.target.elements.keyword.value;
            const address = event.target.elements.address.value;
            



            if (suggestion) {
                url.searchParams.delete('suggestion');
                url.searchParams.set('suggestion', suggestion);
            } else {
                url.searchParams.delete('suggestion');
            }

            if (address) {
                url.searchParams.delete('location');
                url.searchParams.set('location', address);
            } else {
                url.searchParams.delete('location');
            }

            if (keyword) {
                url.searchParams.set('keyword', keyword);
            } else {
                url.searchParams.delete('keyword');
            }
            window.location.href = url.href;
        })
    }


    //message function
    const messages = document.querySelectorAll('.message');

    messages.forEach(function(message) {
        if (message.textContent.trim() !== '') {
            // Show message
            message.style.display = 'block';

            setTimeout(function() {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease-in-out';

                setTimeout(function() {
                    message.remove();
                }, 500);
            }, 2000);
        }
    });
});