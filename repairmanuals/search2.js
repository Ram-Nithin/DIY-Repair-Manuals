// Function to fetch and show search results
function searchManuals() {
    var query = document.getElementById("search-bar").value.toLowerCase();
    var dropdown = document.getElementById("search-dropdown");

    // Clear previous suggestions
    dropdown.innerHTML = '';

    if (query) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
        
        // Set up the request (GET request to a PHP script that handles the search)
        xhr.open("GET", "search_appliance_manuals.php?query=" + encodeURIComponent(query), true);
        
        // Set up the response callback
        xhr.onload = function() {
            if (xhr.status == 200) {
                var results = JSON.parse(xhr.responseText);
                
                // If there are results, display them in the dropdown
                if (results.length > 0) {
                    results.forEach(function(manual) {
                        var listItem = document.createElement('li');
                        listItem.textContent = manual.problem_name;
                        listItem.classList.add('dropdown-item');
                        
                        // Add click event for manual selection
                        listItem.onclick = function() {
                            document.getElementById("search-bar").value = manual.problem_name;
                            dropdown.innerHTML = ''; // Clear dropdown after selection
                            // You can add additional behavior here if needed, but no redirect
                        };

                        dropdown.appendChild(listItem);
                    });
                } else {
                    var listItem = document.createElement('li');
                    listItem.textContent = 'No results found';
                    dropdown.appendChild(listItem);
                }
            }
        };

        // Send the request
        xhr.send();
    }
}
