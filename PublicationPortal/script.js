
function renderPublications() {
    const domain = document.getElementById('domainFilter').value;
    const publication = document.getElementById('publicationFilter').value;
    const type = document.querySelector('input[name="typeFilter"]:checked').value;
    const searchQuery = document.getElementById('searchInput').value;

    const url = `index.php?type=${type}&domain=${domain}&publication=${publication}&search=${searchQuery}`;

    fetch(url)
        .then(response => response.json())
        .then(publications => {
            const publicationList = document.getElementById('publicationList');
            publicationList.innerHTML = '';

            publications.forEach(pub => {
                const card = document.createElement('div');
                card.classList.add('card');

                const cardHtml = `
                    <div class="card-header"><div class="profile-img"></div><b>${pub.DocumentTitle}</b></div>
                    <div class="card-body">
                        <p><b>Domain:</b> ${pub.DomainName}</p>
                        <p><b>Type:</b> ${pub.TypeName}</p>
                        <p><b>Publication:</b> ${pub.PublicationName}</p>
                        <p><b>Year:</b> ${pub.DocumentYear}</p>
                        <button class="btn download-btn" onclick="downloadDocument('${pub.documentfile}')">Download</button>
                        <button class="btn download-btn">Add Bookmark</button>
                    </div>
                `;
                card.innerHTML = cardHtml;
                publicationList.appendChild(card);
            });
        })
        .catch(error => console.error('Error fetching publications:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    renderPublications();

    document.getElementById('domainFilter').addEventListener('change', renderPublications);
    document.getElementById('publicationFilter').addEventListener('change', renderPublications);
    document.getElementById('searchInput').addEventListener('input', renderPublications);

    const typeFilterRadios = document.querySelectorAll('input[name="typeFilter"]');
    typeFilterRadios.forEach(radio => {
        radio.addEventListener('change', renderPublications);
    });

    // Apply hover effect to each card
    $('.card').hover(function() {
        $(this).css('transform', 'scale(1.1)'); // Increase size on hover
    }, function() {
        $(this).css('transform', 'scale(1)'); // Reset size on hover out
    });

    // Apply focus effect on keydown (Enter key) and blur effect on focus lost
    $('.card').on('keydown', function(event) {
        if (event.key === 'Enter') {
            $(this).css('transform', 'scale(1)'); // Increase size on Enter key press
        }
    }).on('blur', function() {
        $(this).css('transform', 'scale(1)'); // Reset size when focus is lost
    });

    // Function to check screen size and toggle sidebar visibility
    function toggleSidebar() {
        if ($(window).width() <= 768) {
            $('.sidebar').hide();
        } else {
            $('.sidebar').show().css('transform', 'translateX(0)');
        }
    }

    // Toggle sidebar initially on page load
    toggleSidebar();

    // Toggle sidebar on window resize
    $(window).resize(function() {
        toggleSidebar();
    });
});

