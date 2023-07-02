<!DOCTYPE html>
<html>
<head>
    <title>URL Counter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        .preloader {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .preloader iframe {
            width: 450px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>URL Counter</h1>
        <div class="form-group">
            <label for="urlsTextarea">Paste URLs:</label>
            <textarea id="urlsTextarea" class="form-control" rows="5" cols="50" placeholder="Paste URLs here"></textarea>
        </div>
        <br>
        <button id="fetchServicesBtn" class="btn btn-primary">Fetch Services</button>
        <hr>
        <h2>Summary</h2>
        <p>Number of URLs: <span id="urlCount">0</span></p>
        <h2>Services</h2>
        <div id="servicesContainer" >
            <div class="preloader">
                <iframe src="https://giphy.com/embed/3oEjI6SIIHBdRxXI40" width="480"
                 height="480" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                <p><a href="https://giphy.com/gifs/mashable-3oEjI6SIIHBdRxXI40">via GIPHY</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#fetchServicesBtn').click(function () {
                var urls = $('#urlsTextarea').val();
                $.ajax({
                    url: '{{ url('fetch-services') }}',
                    method: 'POST',
                    data: { urls: urls },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('.preloader').show();
                    },
                    success: function (response) {
                        $('#urlCount').text(response.urlCount);
                        $('#siteCount').text(response.siteCount);

                        var services = response.services;
                        var servicesContainer = $('#servicesContainer');
                        servicesContainer.empty();

                        for (var i = 0; i < services.length; i++) {
                            var url = services[i].url;
                            var serviceData = services[i].services;

                            var serviceItem = $('<div>').addClass('service-item card p-3 my-4 shadow');
                            var urlElement = $('<h3>').text(url);
                            var serviceList = $('<ul>');

                            for (var key in serviceData) {
                                if (serviceData.hasOwnProperty(key)) {
                                    var value = serviceData[key];
                                    if (value) {
                                        var listItem = $('<li>').text(value);
                                        serviceList.append(listItem);
                                    }
                                }
                            }

                            serviceItem.append(urlElement);
                            serviceItem.append(serviceList);
                            servicesContainer.append(serviceItem);
                        }
                    },
                    complete: function () {
                        $('.preloader').hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
