const regex = {
    // Nom : lettres, espaces, tirets, apostrophes, 2-50 caractères
    nom: /^[a-zA-ZÀ-ÿ\s\-']{2,50}$/,

    // Nom de chanson : lettres, chiffres, espaces, tirets
    chanson: /^[a-zA-ZÀ-ÿ0-9\s\-']{1,32}$/,

    // Durée : nombre entier positif
    duree: /^\d+$/,

    // Fichier mp3
    fichier: /^.+\.mp3$/i,

    // URL de photo
    photo: /^.+\.(jpg|jpeg|png|gif|webp)$/i,

    //Entre 0 et 500 characteres
    description: /^.{0,500}$/,
    // Date : format YYYY-MM-DD
    date: /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/,
};

// Fonction de validation
function valider(champ, valeur) {
    if (!regex[champ]) {
        console.warn('Regex non définie pour : ' + champ);
        return false;
    }

    const valide = regex[champ].test(valeur);

    if (!valide) {
        console.error(`Champ "${champ}" invalide : ${valeur}`);
    }

    return valide;
}


document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    if (form) {
        form.addEventListener('submit', (e) => {
            let erreurs = [];

            const nom = form.querySelector('[name="nom"]');
            const duree = form.querySelector('[name="duree"]');
            const fichier = form.querySelector('[name="fichier"]');
            const date = form.querySelector('[name="date_sortie"]');

            if (nom && !valider('nom', nom.value)) {
                erreurs.push('Nom invalide — 2 à 50 caractères, lettres seulement.');
            }

            if (duree && !valider('duree', duree.value)) {
                erreurs.push('Durée invalide — nombre entier positif seulement.');
            }

            if (fichier && fichier.value && !valider('fichier', fichier.value)) {
                erreurs.push('Fichier invalide — doit être un .mp3.');
            }

            if (date && !valider('date', date.value)) {
                erreurs.push('Date invalide — format YYYY-MM-DD.');
            }

            if (description && description.value && !/^.{0,500}$/.test(description.value)) {
                erreurs.push('Description invalide — maximum 500 caractères.');
            }

            if (erreurs.length > 0) {
                e.preventDefault();

                let conteneur = document.getElementById('erreurs-js');
                if (!conteneur) {
                    conteneur = document.createElement('div');
                    conteneur.id = 'erreurs-js';
                    conteneur.style.cssText = 'background: rgba(255,80,80,0.2); border: 1px solid rgba(255,80,80,0.5); color: #ffaaaa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;';
                    form.prepend(conteneur);
                }

                conteneur.innerHTML = '<ul>' + erreurs.map(e => `<li>${e}</li>`).join('') + '</ul>';
            }
        });
    }
});
