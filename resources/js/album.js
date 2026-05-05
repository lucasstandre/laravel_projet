//Pour chercher des chansons
async function fetchAlbums() {
    try {
        const response = await fetch('/api/albums', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error('Erreur ' + response.status);
        }

        const albums = await response.json();

        const container = document.getElementById('albums-container');
        container.innerHTML = '';

        albums.forEach(album => {
            container.innerHTML += `
                <div class="album-card">
                    <img src="/images/${album.photo}" alt="${album.nom}">
                    <div>
                        <p><strong>${album.nom}</strong></p>
                    </div>
                </div>
            `;
        });

    } catch (error) {
        console.error('Erreur fetch:', error);
    }
}

document.addEventListener('DOMContentLoaded', fetchAlbums);
