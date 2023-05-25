<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>" />
  <title>Prueba Técnica - Isaac Ortega</title>
</head>

<body>
  <div class="headerContainer">
    <h1>Búsqueda y gestión de usuarios</h1>
    <h3>Isaac Ortega - Random User Api</h3>
  </div>
  <div class="generalContainer">
    <div class="formContainer">
      <form>
        <input class="searchButton" type="submit" value="Buscar usuarios API" />
        <input class="buttonDataBaseUsers" type="submit" value="Mostrar Base de Datos" />
      </form>
    </div>
    <div class="informationContainer">
      <div id="usersContainer" class="usersContainer">
      </div>
      <div id="statusContainer" class="statusContainer">
        <h2 class="statusTitle">STATUS:</h2>
      </div>
    </div>
    <div id="dbContainer" class="dbContainer">

    </div>
  </div>


  <script type="text/javascript">
    //Se inicia la función cuando el documento está cargado:
    $(document).ready(function() {
      //Se construye la función para buscar usuarios en BD
      //sobre el botón con la siguiente clase:
      $(".buttonDataBaseUsers").click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "GET",
          url: "getDataDB.php",
          success: function(response) {
            //Se resetea el div con id dbContainer cada vez que se 
            //ejecute la función, para limpiar los valores anteriores
            //y cargar una nueva tabla:
            $("#dbContainer").empty();
            let dbTable =
              "<table>" +
              "<tr>" +
              "<th>ID</th>" +
              "<th>Género</th>" +
              "<th>Nombre</th>" +
              "<th>Apellido</th>" +
              "<th>Ciudad</th>" +
              "<th>Gestión en BD</th>";
            "</tr>";
            if (response) {
              //Se pasan los datos en json para manipularlos:
              let parseDataUser = JSON.parse(response)
              let dataUserLength = parseDataUser.length;
              for (let i = 0; i < dataUserLength; i++) {
                let id = parseDataUser[i].id;
                let gender = parseDataUser[i].gender;
                let name = parseDataUser[i].nameUser;
                let lastname = parseDataUser[i].lastname;
                let city = parseDataUser[i].city;

                dbTable +=
                  "<table>" +
                  "<tr class='rowsDB'>" +
                  "<td class='id'>" +
                  id +
                  "</td>" +
                  "<td class='gender'>" +
                  gender +
                  "</td>" +
                  "<td class='name'>" +
                  name +
                  "</td>" +
                  "<td class='lastname'>" +
                  lastname +
                  "</td>" +
                  "<td class='city'>" +
                  city +
                  "</td>" +
                  "<td>" +
                  `<a action='./ClassConnection.php' method='POST'>Eliminar</a>` +
                  "</td>" +
                  "</tr>" +
                  "</table>";
              }
              dbTable += "</table>";
              //Se recorre la tabla creada al div con el siguiente id:
              $("#dbContainer").append(dbTable);
              //Se recorre cada fila para poder manipularlas por separado:
              $(".rowsDB").each(function(index) {
                $(this).click(function(each) {
                  //Se localiza con closest el elemento con la clase .rowsDB
                  //para manipular su contenido con el índice señalado:
                  let userDeleted = $(this).closest(".rowsDB").find("td");
                  let idToDelete = userDeleted[0].innerHTML;
                  let deleteButton = userDeleted[5];
                  //Se ejecuta la función deleteUser() que se 
                  //construido fuera del bucle buscando mayor eficiencia
                  deleteUser(idToDelete, deleteButton);
                })
              })
            } else {
              let errorMessage =
                "<h2>La petición no se ha podido realizar,<br> asegúrate de que el método pasado es <br>'GET' y que las variables de entorno son correctas</h2>";
              return $("#statusContainer").append(errorMessage);
            }
          }
        })
      })
      //Se construye la función de búsqueda a la API randomuser
      //añadiéndole el evento click al input con clase searchButton
      $(".searchButton").click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "GET",
          url: "dataApi.php",
          success: function(response) {
            $("#usersContainer").empty();
            $("#statusContainer").find("h2:gt(0)").remove();
            let results = JSON.parse(response);
            if (results === "ERROR") {
              let errorMessage =
                "<h2>La petición no se ha podido realizar,<br> asegúrate de que el método pasado es <br>'GET'</h2>";
              return $("#statusContainer").append(errorMessage);
            }
            console.log(results)
            //Se recogen los datos de los usuarios, separados de la información
            //de status, para así trabajar con cada uno de ellos
            let lengthResults = results[1].length;
            let status = results[0];
            let statusInfo = "<h2>" + status + "</h2>";
            let usersTable =
              "<table>" +
              "<tr>" +
              "<th>Género</th>" +
              "<th>Nombre</th>" +
              "<th>Apellido</th>" +
              "<th>Ciudad</th>" +
              "<th>Gestión en BD</th>";
            "</tr>";
            let statusTitle = document.getElementsByClassName('statusTitle')[0];
            //Cambio el estilo de el elemento h2 para que se muestre sólo
            //cuando se muestran resultados de la API.
            //En este div se mostrará el status, 200 si es correcto
            //mensaje de error si hay algún problema en la solicitud
            statusTitle.style.display = 'block';
            $("#statusContainer").append(statusInfo);
            for (let i = 0; i < lengthResults; i++) {
              let userGender = results[1][i].gender;
              let userName = results[1][i].name.first;
              let userLastname = results[1][i].name.last;
              let userCity = results[1][i].location.city;
              usersTable +=
                "<table>" +
                "<tr class='rows'>" +
                "<td name='gender' class='gender'>" +
                userGender +
                "</td>" +
                "<td name='nameUser' class='name'>" +
                userName +
                "</td>" +
                "<td name='lastname' class='lastname'>" +
                userLastname +
                "</td>" +
                "<td name='city' class='city'>" +
                userCity +
                "</td>" +
                "<td>" +
                `<a action='./ClassConnection.php' method='POST'>Guardar</a>` +
                "</td>" +
                "</tr>" +
                "</table>";
            }
            usersTable += "</table>";
            //Se añade la tabla al div correspondiente:
            $("#usersContainer").append(usersTable);
            $(".rows").each(function(index) {
              $(this).click(function(each) {
                let userSaved = $(this).closest(".rows").find("td");
                let gender = userSaved[0].innerHTML;
                let nameUser = userSaved[1].innerHTML;
                let lastname = userSaved[2].innerHTML;
                let city = userSaved[3].innerHTML;
                //La función sendUser() se ejecuta dentro del for, con los parámetros
                //indicados, pero se construye fuera del bucle para mayor eficiencia
                sendUser(gender, nameUser, lastname, city, userSaved);
              })
            })
          },
        });
      });
      //Construyo la función sendUser() guardando los valores 
      //recogidos en el bucle anterior
      function sendUser(gender, nameUser, lastname, city, userSaved) {
        $.ajax({
          type: "POST",
          url: "insertDataDB.php",
          data: {
            gender,
            nameUser,
            lastname,
            city
          },
          success: function(response) {
            if (response) {
              //Se manipula el DOM cuando se ejecuta la función
              //modificando el elemento a de Guardar:
              userSaved[4].innerHTML = 'Guardado';
              userSaved[4].style.color = 'red';
            } else {
              console.log("<h2>La petición no se ha podido realizar,<br> asegúrate de que el método pasado es <br>'POST' y que las variables de entorno son correctas</h2>");
            }
          }
        });
      }
      //Se construye la función deleteUser, con los valores de los
      //parámetros que se recogen más arriba.
      function deleteUser(idToDelete, deleteButton) {
        $.ajax({
          type: "POST",
          url: "deleteData.php",
          data: {
            id: idToDelete
          },
          success: function(response) {
            deleteButton.innerHTML = 'Eliminado';
            deleteButton.style.color = 'red';
          }
        })
      }
    });
  </script>
</body>

</html>