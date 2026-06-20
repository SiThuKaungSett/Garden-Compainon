document.addEventListener("DOMContentLoaded", function () {
    const searchBox = document.getElementById("searchBox");
    const searchResults = document.getElementById("searchResults");

    searchBox.addEventListener("input", function () {
        let query = searchBox.value.trim();
        
        if (query.length === 0) {
            searchResults.style.display = "none";
            return;
        }

        // Send AJAX request to fetch search results
        fetch(`search.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = "";
                
                if (data.length === 0) {
                    searchResults.style.display = "none";
                    return;
                }

                data.forEach(item => {
                    let li = document.createElement("li");
                    li.innerHTML = `<img src="uploads/${item.image}" width="40" height="40" style="border-radius:5px; margin-right:10px;">
                                    <span>${item.name}</span>`;
                    li.classList.add("search-item");
                    li.setAttribute("data-id", item.p_id); // Ensure p_id is assigned properly
                    
                    li.addEventListener("click", function () {
                        let productId = li.getAttribute("data-id");
                        if (productId) {
                            window.location.href = `moredetail.php?id=${productId}`; // Redirect to detail page
                        }
                    });

                    searchResults.appendChild(li);
                });

                searchResults.style.display = "block";
            })
            .catch(error => console.error("Error fetching search results:", error));
    });

    // Hide dropdown if clicked outside
    document.addEventListener("click", function (event) {
        if (!searchBox.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.style.display = "none";
        }
    });
});

function showToast() {
    let toast = document.getElementById("toast");
    toast.classList.add("show");

    // Hide toast after 2 seconds and redirect to login page
    setTimeout(function() {
        toast.classList.remove("show");
        window.location.href = "adlogin.php";
    }, 2000);
}

