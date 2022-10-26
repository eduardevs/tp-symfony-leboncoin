console.log("hello");

const btnDelete = document.getElementsByClassName("btn-danger");
console.log(btnDelete);

const confirmDelete = () => {
        confirm("Vous êtes sûr de supprimer l'utilisateur ?");
}
btnDelete.addEventListener("click", confirmDelete());

