<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
      * { box-sizing: border-box; }
      body {
        font: 16px Arial;
      }
      .autocomplete {
        /*the container must be positioned relative:*/
        position: relative;
        display: inline-block;
      }
      input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
      }
      input[type="text"] {
        background-color: #f1f1f1;
        width: 100%;
      }
      input[type="submit"] {
        background-color: DodgerBlue;
        color: #fff;
      }
      .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
      }
      .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
      }
      .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #e9e9e9;
      }
      .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
      }
    </style>
  </head>

  <header class="py-4 bg-dark bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="d-flex align-items-center">
            <a href="{{ route('root') }}" class="text-white text-decoration-none">
              <h1 class="mb-0">Forum</h1>
            </a>
            <div class="ml-3 navbar navbar-expand-lg navbar-dark">
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                  @guest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                  </li>
                  @else
                  <li class="nav-item">
                    <span class="nav-link">Hi, {{ Auth::user()->name }}</span>
                  </li>
                  <li class="nav-item dropdown">
                    <a
                      class="nav-link dropdown-toggle"
                      href="#"
                      id="navbarDropdownMenuLink"
                      role="button"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      my account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a>
                    </div>
                  </li>
                  @endguest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('places') }}">Places</a>
                  </li>
                  <li>
                    @auth
                        @if (auth()->user()->role === 1)
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Edit users</a>
                        @endif
                    @endauth

                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <form action="{{ route('cities.search') }}" method="GET" class="d-flex justify-content-end" autocomplete="off" >
            <input class="form-control me-2" id="cityInput" type="search" placeholder="City" aria-label="Search" name="search">
            <button class="btn btn-secondary" type="submit">Search</button>
          </form>
        </div>
        <div class="col-md-3">
            <form action="{{ route('tags.search') }}" method="GET" class="d-flex justify-content-end" autocomplete="off" >


                <input class="form-control me-2" id="tagInput" type="search" name="tag" placeholder="Tag" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Search</button>

            </form>
          </div>
      </div>
    </div>
  </header>
  <script>
    // Pobieranie nazw tagów i miast
    var cities = {!! json_encode($cities->pluck('name')) !!};
    var countries = {!! json_encode($tag->pluck('name')) !!};

    // Funkcja do obsługi funkcjonalności automatycznego uzupełniania pól tekstowych
    function autocomplete(inp, arr) {
        var currentFocus;

        // Wywołanie funkcji po wpisaniu tekstu w pole tekstowe
        inp.addEventListener("input", function (e) {
            var val = this.value;
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            var a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);

            // Iteracja przez elementy i sprawdzanie dopasowań
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    var b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                    // Obsługa kliknięcia na element
                    b.addEventListener("click", function (e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });

                    a.appendChild(b);
                }
            }
        });

        // Obsługa klawiatury
        inp.addEventListener("keydown", function (e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });

        // Pokazuje pasujące elementy
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = x.length - 1;
            x[currentFocus].classList.add("autocomplete-active");
        }

        // Usuwa aktywność z elementów
        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        // Zamyka wszystkie listy z uzupełnieniami
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        // Zamyka listy po kliknięciu na inne elementy
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    // Inicjalizacja funkcjonalności autocomplete dla pól tekstowych
    autocomplete(document.getElementById("cityInput"), cities);
    autocomplete(document.getElementById("tagInput"), countries);

</script>
