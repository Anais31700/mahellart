'use strict';

// Fonction asynchrone pour gérer les likes
async function handleLikeClick(button) {
    const realisationId = button.getAttribute('data-realisation-id');
    const isLiked = button.classList.contains('liked');
    const action = isLiked ? 'unlike' : 'like';

    try {
        const response = await fetch('index.php?controller=Realisations&task=' + action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'realisation_id=' + realisationId,
        });
        const data = await response.json();

        if (data.success) {
            button.classList.toggle('liked');
            const heartIcon = button.querySelector('.fa-heart');
            heartIcon.style.color = isLiked ? 'white' : 'red'; // Change la couleur du cœur
            const likeCountElement = button.parentElement.querySelector('.like-count');
            let likeCount = parseInt(likeCountElement.textContent.split(' ')[0]);
            likeCount = isLiked ? likeCount - 1 : likeCount + 1;
            likeCountElement.textContent = likeCount + " 'j'aimes";
        } else {
            throw new Error('Erreur lors de la mise à jour du like.');
        }
    } catch (error) {
        const messageElement = document.getElementById('message');
        messageElement.textContent =
            "Une erreur s'est produite lors de la mise à jour du like. Veuillez réessayer.";
        messageElement.style.display = 'block';
        console.error(error.message);
    }
}

function setupLikes() {
    document.querySelectorAll('.like-button').forEach((button) => {
        button.addEventListener('click', () => handleLikeClick(button));
    });
}

// Fonction pour mettre à jour la date et l'heure
function updateDateTime() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const dateStr = `${day}/${month}/${year}`;
    const timeStr = `${hours}:${minutes}:${seconds}`;

    document.querySelector('#dateNow').textContent = `Nous sommes le ${dateStr}`;
    document.querySelector('#hourNow').textContent = `Il est ${timeStr}`;
}

// Exécution des fonctions après le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    updateDateTime();
    setInterval(updateDateTime, 1000);
    setupLikes();
});
