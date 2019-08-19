<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <?php

    class MovieList
    {
        public static $movieList = null;
        public static $color = null;
    }

    //method to search for which color
    function searchTitle($titleString)
    {
        if (strpos($titleString, 'red') !== false) {
            MovieList::$color = 'red';
        } elseif (strpos($titleString, 'green') !== false) {
            MovieList::$color = 'green';
        } elseif (strpos($titleString, 'blue') !== false) {
            MovieList::$color = 'blue';
        } elseif (strpos($titleString, 'yellow') !== false) {
            MovieList::$color = 'yellow';
        } else {
            MovieList::$color = '';
        }
        return MovieList::$color;
    }

    if (!$_POST) { //If it is the first time, it does nothing
        echo "Please search the movie";
    } else {
        if (getTitle() !== null) {
            apiResponseArray();
        }
    }

    function getTitle()
    {
        $title = $_POST['searchfield'];
        $title = searchTitle($title);
        return $title;
    }


    function apiResponseArray()
    {
        MovieList::$movieList = null;
        $title = getTitle();
        //for my test case i will be using green
        $jsonURL = "http://www.omdbapi.com/?" . "t=" . $title . "&apikey=544bf1e1";
        $moviesFile = file_get_contents($jsonURL);
        $movies = json_decode($moviesFile, true);

        MovieList::$movieList[] = $movies;
    }


    ?>
<body>
<div class='container <?php MovieList::$color ?>'>
    <h2>Interview test</h2>
    <p>Show the movies that have the color, Press the button to display movies.</p>
    <!--call php function with button for red, green, blue or yellow. and change background color accordingly.-->
    <form action="searchpage.php" method="post" class="text-right">
        <input type="text" name="searchfield" placeholder="enter a text"/>
        <input type="submit" value="submit" class="btn btn-secondary" onclick="apiResponseArray()"/>
    </form>
    <div>
        <hr>
    <?php
    if (!empty(MovieList::$movieList)) {
        foreach (MovieList::$movieList as $key => $movie) {
            echo "<table class=\"table table-dark\">
                  <thead>
                    <tr>
                      <th scope=\"col\">#</th>
                      <th scope=\"col\">Title</th>
                      <th scope=\"col\">Year</th>
                      <th scope=\"col\">Runtime</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <th scope=\"row\">$key</th>
                        <td>".$movie["Title"]."</td>
                        <td>".$movie["Year"]."</td>
                        <td>".$movie["Runtime"]."</td>
                     </tr>
                    ";

        }
    } else {
        echo "no entry to print";
    }
    ?>
        
</div>
</body>
</html>
