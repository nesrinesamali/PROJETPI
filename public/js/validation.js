document.getElementById('calendrierForm').addEventListener('submit', function(event) {
    // Réinitialiser les messages d'erreur
    document.getElementById('IdMedecinError').innerText = '';
    document.getElementById('jourFeriesError').innerText = '';
    document.getElementById('infosError').innerText = '';
    document.getElementById('diagnostiqueError').innerText = '';

    // Validation ID Médecin
    let IdMedecinInput = document.getElementById('IdMedecin');
    if (IdMedecinInput.value === '' || isNaN(IdMedecinInput.value)) {
        document.getElementById('IdMedecinError').innerText = 'Veuillez entrer un ID Médecin valide.';
        event.preventDefault();
    }

    // Validation Jour Feries
    let jourFeriesInput = document.getElementById('jourFeries');
    if (jourFeriesInput.value === '' || isNaN(jourFeriesInput.value)) {
        document.getElementById('jourFeriesError').innerText = 'Veuillez entrer un Jour Feries valide.';
        event.preventDefault();
    }

    // Validation Infos
    let infosInput = document.getElementById('infos');
    if (infosInput.value === '') {
        document.getElementById('infosError').innerText = 'Veuillez entrer des informations valides.';
        event.preventDefault();
    }

    // Validation Diagnostique
    let diagnostiqueInput = document.getElementById('diagnostique');
    if (diagnostiqueInput.value === '') {
        document.getElementById('diagnostiqueError').innerText = 'Veuillez entrer un diagnostique valide.';
        event.preventDefault();
    }
});    