document.addEventListener('DOMContentLoaded', function() {
   
    let membres = [
        { id: 1, nom: "Jean Dupont", email: "jean.dupont@example.com" },
        { id: 2, nom: "Marie Curie", email: "marie.curie@example.com" },
        { id: 3, nom: "Pierre Durand", email: "pierre.durand@example.com" },
    ];

 
    const tableauMembres = document.getElementById('tableau-membres').getElementsByTagName('tbody')[0];
    const formulaireAjouterMembre = document.getElementById('ajouter-membre-form');
    const messagesContainer = document.getElementById('messages');
    const formulaireMessage = document.getElementById('envoyer-message-form');

    
    function afficherMembres() {
        tableauMembres.innerHTML = '';
        membres.forEach(membre => {
            const ligne = document.createElement('tr');
            ligne.innerHTML = `
                <td>${membre.nom}</td>
                <td>${membre.email}</td>
                <td>
                    <button onclick="supprimerMembre(${membre.id})">Supprimer</button>
                </td>
            `;
            tableauMembres.appendChild(ligne);
        });
    }

    // Ajouter un membre
    formulaireAjouterMembre.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        const email = document.getElementById('membre-email').value;
        const nom= document.getElementById('nomdumembres').value;

        // Simuler l'ajout d'un membre (à remplacer par une requête AJAX)
        const nouveauMembre = {
            id: membres.length + 1,
            nom:nom, // À remplacer par le nom récupéré depuis le serveur
            email: email,
        };

        membres.push(nouveauMembre); // Ajouter le membre à la liste
        afficherMembres(); // Mettre à jour le tableau

        // Réinitialiser le formulaire
        formulaireAjouterMembre.reset();
    });

    // Supprimer un membre
    window.supprimerMembre = function(id) {
        membres = membres.filter(membre => membre.id !== id); // Filtrer le membre à supprimer
        afficherMembres(); // Mettre à jour le tableau
    };

    // Gérer la discussion
    formulaireMessage.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        const message = document.getElementById('message').value;

        // Ajouter le message à la discussion
        const messageElement = document.createElement('div');
        messageElement.textContent = `Vous : ${message}`;
        messagesContainer.appendChild(messageElement);

        // Réinitialiser le champ de message
        formulaireMessage.reset();

        // Faire défiler la discussion vers le bas
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });

    // Afficher les membres au chargement de la page
    afficherMembres();
});