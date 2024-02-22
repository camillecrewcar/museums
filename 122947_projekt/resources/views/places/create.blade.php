<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Place</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<body>
    @include('shared.header')

    <div class="container">
        <h1>Create New Place</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <form action="{{ route('places.store') }}" novalidate enctype="multipart/form-data" method="POST">
            @csrf

            <div class="form-group">
                <label for="name"><h3>Name</h3></label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="type"><h3>Type</h3></label>
                <br>


                <div class="form-check">
                  <input class="form-check-input" type="radio" name="type" id="monument" value="Monument" checked
                    onclick="validateInput()">
                  <label class="form-check-label" for="monument">Monument</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="type" id="museum" value="Museum"
                    onclick="validateInput()">
                  <label class="form-check-label" for="museum">Museum</label>
                </div>
                <label id="help">Enter monument code. Sample code: PL.1.9.ZIPOZ.NID_N_24_BK.106160. You can find monument
                  codes <a href='https://dane.gov.pl/pl/dataset/1130/resource/45721/table?page=1&per_page=20&q=&sort='> here</a>
                </label>
                <br>
                <input type="text" name="monument_code" id="monument_code" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="latitude"><h3>Latitude</h3></label>
                <input type="number" name="latitude" id="latitude" class="form-control" step="0.000001" required>
              </div>

              <div class="form-group">
                <label for="longitude"><h3>Longitude</h3></label>
                <input type="number" name="longitude" id="longitude" class="form-control" step="0.000001" required>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
              </div>
            <!-- Opening hours -->
            <h3>Opening Hours</h3>

            <div class="row">
                <div class="col">
                    <label for="monday_opening_time">Monday</label>
                    <input type="time" name="opening_hours[monday][opening_time]" id="monday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="monday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[monday][closing_time]" id="monday_closing_time"
                        class="form-control">
                </div>
            </div>

            <!-- Repeat the above row for Tuesday to Sunday -->

            <div class="row">
                <div class="col">
                    <label for="tuesday_opening_time">Tuesday</label>
                    <input type="time" name="opening_hours[tuesday][opening_time]" id="tuesday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="tuesday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[tuesday][closing_time]" id="tuesday_closing_time"
                        class="form-control">
                </div>
            </div>

            <!-- Repeat the above row for Wednesday to Sunday -->

            <div class="row">
                <div class="col">
                    <label for="wednesday_opening_time">Wednesday</label>
                    <input type="time" name="opening_hours[wednesday][opening_time]" id="wednesday_opening_time" class="form-control">
                </div>
                <div class="col">
                    <label for="wednesday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[wednesday][closing_time]" id="wednesday_closing_time"
                        class="form-control">
                </div>
            </div>

            <!-- Repeat the above row for Thursday to Sunday -->

            <div class="row">
                <div class="col">
                    <label for="thursday_opening_time">Thursday</label>
                    <input type="time" name="opening_hours[thursday][opening_time]" id="thursday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="thursday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[thursday][closing_time]" id="thursday_closing_time"
                        class="form-control">
                </div>
            </div>

            <!-- Repeat the above row for Friday to Sunday -->

            <div class="row">
                <div class="col">
                    <label for="friday_opening_time">Friday</label>
                    <input type="time" name="opening_hours[friday][opening_time]" id="friday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="friday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[friday][closing_time]" id="friday_closing_time"
                        class="form-control">
                </div>
            </div>

            <!-- Repeat the above row for Saturday to Sunday -->

            <div class="row">
                <div class="col">
                    <label for="saturday_opening_time">Saturday</label>
                    <input type="time" name="opening_hours[saturday][opening_time]" id="saturday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="saturday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[saturday][closing_time]" id="saturday_closing_time"
                        class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="sunday_opening_time">Sunday</label>
                    <input type="time" name="opening_hours[sunday][opening_time]" id="sunday_opening_time"
                        class="form-control">
                </div>
                <div class="col">
                    <label for="sunday_closing_time">&nbsp;</label>
                    <input type="time" name="opening_hours[sunday][closing_time]" id="sunday_closing_time"
                        class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" accept="image/jpeg, image/png" class="form-control-file">
                <small class="text-muted">Accepted formats: JPEG, PNG</small>
            </div>

            <div class="form-group mt-4">
                <button type="submit" onclick="handleFormSubmit(event)" class="btn btn-secondary">Create Place</button>
              </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function validateInput() {
          var input = document.getElementById("name").value; // Retrieve the value of the "Name" input field
          var help = document.getElementById("help");
          var form = document.querySelector('form');

          if (document.getElementById("monument").checked) {
            var monumentPattern = /^PL\.1\.9\.ZIPOZ\.NID_N_\d{2}_[A-Z]{2}\.\d+/;
            help.innerHTML = "Enter monument code. Sample code: PL.1.9.ZIPOZ.NID_N_24_BK.106160. You can find monument codes <a href='https://dane.gov.pl/pl/dataset/1130/resource/45721/table?page=1&per_page=20&q=&sort='> here</a> ";
            form.onsubmit = handleFormSubmit; // Bind the handleFormSubmit function to form's onsubmit event
          } else if (document.getElementById("museum").checked) {
            var nipPattern = /^\d{10,12}$/;
            help.innerHTML = "Enter NIP code";
            form.onsubmit = handleFormSubmit; // Bind the handleFormSubmit function to form's onsubmit event
          }
        }

        function handleFormSubmit(event) {
            var input = document.getElementById("monument_code").value;
            var help = document.getElementById("help");
            var monumentPattern = /^PL\.1\.9\.ZIPOZ\.NID_N_\d{2}_[A-Z]{2}\.\d+/;
            var nipPattern = /^\d{10,12}$/;
            var isValid = true;

            var openingTimes = document.querySelectorAll('input[id$="_opening_time"]');
            var closingTimes = document.querySelectorAll('input[id$="_closing_time"]');
            var isValid = true;

            for (var i = 0; i < openingTimes.length; i++) {
                var openingTime = openingTimes[i].value.trim();
                var closingTime = closingTimes[i].value.trim();

                if (openingTime !== "" && closingTime === "") {
                    alert("Please specify the closing time for " + openingTimes[i].name);
                    isValid = false;
                    break;
                }
            }

            if (document.getElementById("monument").checked) {
                if (!monumentPattern.test(input)) {
                    alert("Invalid monument code!");
                    isValid = false;
                }
            } else if (document.getElementById("museum").checked) {
                if (!nipPattern.test(input)) {
                    alert("Invalid NIP code!");
                    isValid = false;
                }
            }

            // Check if any of the required fields are empty
            var requiredFields = document.querySelectorAll('input[required], textarea[required]');
            for (var i = 0; i < requiredFields.length; i++) {
                if (requiredFields[i].value.trim() === "") {
                    alert("Please fill in all required fields.");
                    isValid = false;
                    break;
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        }

        // Bind the handleFormSubmit function to the form's onsubmit event
        var form = document.querySelector('form');
        form.addEventListener('submit', handleFormSubmit);
      </script>
</body>

</html>
