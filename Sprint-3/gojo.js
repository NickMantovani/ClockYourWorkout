document.addEventListener("DOMContentLoaded", function() {
    fetchResults();

    document.getElementById("exerciseForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch("submit.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchResults();
        })
        .catch(error => console.error("Error:", error));
    });

    function fetchResults() {
        fetch("results.php")
            .then(response => response.json())
            .then(data => {
                let resultsDiv = document.getElementById("results");
                resultsDiv.innerHTML = "";
                for (let exercise in data) {
                    resultsDiv.innerHTML += `<p>${exercise}: ${data[exercise]} seleções</p>`;
                }
            })
            .catch(error => console.error("Error:", error));
    }
});
