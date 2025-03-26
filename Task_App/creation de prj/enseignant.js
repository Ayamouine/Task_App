document.addEventListener('DOMContentLoaded', function() {
    // Exemple de données de projets (à remplacer par une requête AJAX vers le serveur)
    const projects = [
        { id: 1, name: "Projet 1", description: "Description du projet 1", students: [1, 2] },
        { id: 2, name: "Projet 2", description: "Description du projet 2", students: [3] },
    ];

    const projectList = document.getElementById('project-list');

    projects.forEach(project => {
        const li = document.createElement('li');
        li.innerHTML = `<strong>${project.name}</strong> - ${project.description} (Étudiants: ${project.students.join(', ')})`;
        projectList.appendChild(li);
    });
});
