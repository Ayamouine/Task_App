document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour du profil
    const profileForm = document.querySelector('.profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profil mis à jour avec succès!');
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        });
    }
});
