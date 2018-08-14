<?php



function mostSeen($Connection){
    $sql =  "SELECT * FROM admin_panel ORDER BY RAND()  LIMIT 2";
    $res = $Connection->query($sql);
    while ($fila = $res->fetch_array()) {
        $PostId = $fila['id'];
        $DateTime = $fila['datetime'];
        $Tittle = $fila['title'];
        $Category = $fila['category'];
        $Admin = $fila['author'];
        $Image = $fila['image'];
        $Post = $fila['post'];

    echo "<div>";
        echo "<a href=FullPost.php?id=$PostId>";
            echo "<p class='cat'>";
            echo htmlentities($Category);
            echo "</p>";

            echo "<img src='Upload/$Image' width='100%'>";

            echo "<h4>";
            echo htmlentities("$Tittle");
            echo "</h4>";
        echo "</a>";
    echo "</div>";
    echo "<br>";
    }
}


function trending($Connection){
    $sql =  "SELECT * FROM admin_panel ORDER BY seen desc  LIMIT 4";
    $res = $Connection->query($sql);
    while ($fila = $res->fetch_array()) {
        $PostId = $fila['id'];
        $DateTime = $fila['datetime'];
        $Tittle = $fila['title'];
        $Category = $fila['category'];
        $Admin = $fila['author'];
        $Image = $fila['image'];
        $Post = $fila['post'];

    echo "<div class='trend'>";

    echo "<a href='FullPost.php?id=$PostId'>";
    echo "<h4>";
    echo htmlentities("$Tittle");
    echo "</h4>";
    echo "</a>";


    echo "</div>";
        echo "<div class='border'> </div>";

    }
}


function lastCreated($Connection){

    $Query = 'SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 2,2';


    $res = $Connection->query($Query);

    while ($fila = $res->fetch_array()) {
      $PostId = $fila['id'];
      $DateTime = $fila['datetime'];
      $Tittle = $fila['title'];
      $Category = $fila['category'];
      $Author = $fila['author'];
      $Image = $fila['image'];
      $Post = $fila['post'];

    echo "<a class='Post2' href='FullPost.php?id=$PostId'>";
    echo "<div class='blogpost2'>";
        echo "<div class='col-xs-12 col-md-6'>";
            echo "<img class='img-responsive' src='Upload/$Image' alt=''>";
        echo "</div>";
        echo "<div class='caption2 col-xs-12 col-sm-6'>";
            echo "<p class='category2'>$Category</p>";
            echo "<h1 id='heading2'>$Tittle</h1>";
            echo "<p class='date2'>Por ";
             if($Author="BELIVE")
                 echo "<small><small>BE</small></small>LIVE ";
             else
                 echo "$Author";

            echo"  |  $DateTime</p>";


            echo "<a href='#' class='red' id='fb'";
                echo  "onclick='window.open(";
                echo  addslashes("&#39;http:&#47;&#47;www.facebook.com/sharer.php?u=http:&#47;&#47;www.belive.com.mx/FullPost.php?id=$PostId&#39;");
                echo        ",&#39;www.belive.com.mx&#39;,&#39;width =550,height=400&#39;);'>";

            echo          "<div >
                          <i class='fa fa-facebook fa-lg'></i>
                      </div>
                  </a>";


            echo "<a href='#' class='red' id='tw'";
                  echo"onclick='window.open(";
                  echo "&#39;https://twitter.com/intent/tweet?url=http://www.belive.com.mx/FullPost.php?id=$PostId&text=$Tittle%20por%20@REVISTABELIVE&#39;,&#39;www.belive.com.mx&#39;,&#39;width =550,height=400&#39;);'  >";
            echo     "<div >
                          <i class='fa fa-twitter fa-lg'></i>
                      </div>
                  </a>";



            echo "<a href='#' class='red' id='g'";
                  echo "onclick='window.open(";
                  echo"&#39;https://plus.google.com/share?url=http://www.belive.com.mx/FullPost.php?id=$PostId&text=$Tittle%20por%20@REVISTABELIVE&#39;,&#39;www.belive.com.mx&#39;,&#39;width =550,height=400&#39;);'>";
            echo "<div >
                          <i class='fa fa-google-plus fa-lg'></i>
                      </div>
                  </a>";


        echo" </div>";

        echo  "</div>";
      echo "</a>";
      echo "<div class='clearfix'></div>";
     }


}
 ?>
