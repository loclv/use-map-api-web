document.getElementById("input_text")
    .addEventListener("keyup", function (event) {
        event.preventDefault();
        if (event.keyCode == 13) {
            document.getElementById("search-btn").click();
        }
    });