document.addEventListener('DOMContentLoaded', () => {
    // Sélectionnez les éléments du DOM nécessaires
    const menuBtn = document.querySelector('.menu-btn');
    const navigation = document.querySelector('.navigation');
    const loginMenu = document.querySelector('.login');

    // Ajoutez un gestionnaire d'événement au clic sur le bouton de menu
    menuBtn.addEventListener('click', () => {
        // Basculez la visibilité de la navigation lors du clic sur le bouton de menu
        navigation.classList.toggle('active');
        loginMenu.classList.toggle('active');
    });

    // Écoutez les modifications de la largeur de l'écran pour masquer la navigation si nécessaire
    window.addEventListener('resize', () => {
        if (window.innerWidth > 1040) {
            // Assurez-vous que la navigation est visible sur les grands écrans
            navigation.classList.remove('active');
        }
    });

});
