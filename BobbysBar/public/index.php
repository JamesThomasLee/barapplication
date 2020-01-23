<!DOCTYPE html>
<html>
<?php include 'header.php';?>

<div class="w3-container" id="about">
    <div class="w3-content" style="max-width: 700px">
        <h5>About Us</h5>
        <p>
            Bobby's bar, opened in 2019 is located in the heart of Plymouth providing it's customers with the highest quality alcoholic
            and non alcoholic beverages along with tasty hot and cold bar snacks.
        </p>
        <p>
            Get your sporting fix. With multiple tv screens and projectors located all around the bar you'll never miss a second of the
            sporting action you love. We show every sport broadcast live on both Sky Sport and BT Sport as well as free to air TV.
            You never even have to miss a second of the action to go to the bar - order your food and drinks via our website and
            have them delivered to your table!
        </p>


        <h5>Location</h5>
        <div id='map' style='width: 700px; height: 600px;'></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoiamFtaWVsZWU5NiIsImEiOiJjam9neXhtMHgwaWw5M3Jyd2gycW9pbDQwIn0.wqFvjrONBW2pIXTVHInd_A';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-4.136182, 50.376367],
                zoom: 14
            });

            //add controls
            map.addControl(new mapboxgl.NavigationControl());

            map.on("load", function () {
                /* Image: An image is loaded and added to the map. */
                map.loadImage("https://i.imgur.com/MK4NUzI.png", function(error, image) {
                    if (error) throw error;
                    map.addImage("custom-marker", image);
                    /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                    map.addLayer({
                        id: "markers",
                        type: "symbol",
                        /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                        source: {
                            type: "geojson",
                            data: {
                                type: 'FeatureCollection',
                                features: [
                                    {
                                        type: 'Feature',
                                        properties: {},
                                        geometry: {
                                            type: "Point",
                                            coordinates: [-4.136182, 50.376367]
                                        }
                                    }
                                ]
                            }
                        },
                        layout: {
                            "icon-image": "custom-marker",
                        }
                    });
                });
            });
        </script>
    </div>
</div>
</body>

<?php include 'footer.php';?>
</html>
