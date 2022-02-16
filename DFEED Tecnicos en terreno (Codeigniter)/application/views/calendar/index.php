<?php

//session_start();
include("database.php");
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = session_id();
}
$uid = $_SESSION['user'];  // set your user id settings
$datetime_string = date('c', time());

if (isset($_POST['action']) or isset($_GET['view'])) {
  if (isset($_GET['view'])) {
    header('Content-Type: application/json');
    $start = mysqli_real_escape_string($connection, $_GET["start"]);
    $end = mysqli_real_escape_string($connection, $_GET["end"]);

    echo $start;
    echo $end;

    $result = mysqli_query($connection, "SELECT `id`, `start` ,`end` ,`title` FROM  `events` where (date(start) >= '$start' AND date(start) <= '$end')");

    print($result);
    return;
    while ($row = mysqli_fetch_assoc($result)) {
      $events[] = $row;
    }
    echo json_encode($events);
    exit;
  } elseif ($_POST['action'] == "add") {
    mysqli_query($connection, "INSERT INTO calendar.`events` (
                    `title` ,
                    `start` ,
                    `end` 
                    )
                    VALUES (
                    '" . mysqli_real_escape_string($connection, $_POST["title"]) . "',
                     '" . mysqli_real_escape_string($connection, date('Y-m-d H:i:s', strtotime($_POST["start"]))) . "',
                    '" . mysqli_real_escape_string($connection, date('Y-m-d H:i:s', strtotime($_POST["end"]))) . "'
                    )");
    header('Content-Type: application/json');
    echo '{"id":"' . mysqli_insert_id($connection) . '"}';
    exit;
  } elseif ($_POST['action'] == "update") {
    mysqli_query($connection, "UPDATE `events` set 
            `start` = '" . mysqli_real_escape_string($connection, date('Y-m-d H:i:s', strtotime($_POST["start"]))) . "', 
            `end` = '" . mysqli_real_escape_string($connection, date('Y-m-d H:i:s', strtotime($_POST["end"]))) . "' 
            where id = '" . mysqli_real_escape_string($connection, $_POST["id"]) . "'");
    exit;
  } elseif ($_POST['action'] == "delete") {
    mysqli_query($connection, "DELETE from `events` where id = '" . mysqli_real_escape_string($connection, $_POST["id"]) . "'");
    if (mysqli_affected_rows($connection) > 0) {
      echo "1";
    }
    exit;
  }
}

?>

<script type="text/javascript">
  var calendar = <?php echo ((json_encode($calendar))); ?>;
  lstCalendar = JSON.stringify(calendar);
</script>

<style>
  body {
    /*margin: 40px 10px;*/
    padding: 0;
    font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
    background-color: white;
  }

  #selectTickets {
    width: 100% !important;
  }
</style>

<link href="<?php echo site_url('assets/css/fullcalendar.css') ?>" rel="stylesheet">
</link>
<script type="text/javascript"></script>
<link href="<?php echo site_url('assets/css/fullcalendar.print.css') ?>" rel="stylesheet" media="print">
</link>
<script src="<?php echo site_url('assets/js/moment.min.js') ?>"></script>
<script type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/fullcalendar.js') ?>"></script>
<script type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/es.js') ?>"></script>
<script type="text/javascript"></script>

<style type="text/css">
  .modal * {
    text-align: left;
  }

  .cuando {
    padding: 1em;
    margin: 10px;
    border: 1px solid gray;
  }
</style>

<div style="max-width: 900px; margin: 0 auto;">
  <div class="container">
    <!--div class="row">
            <?php echo form_open(site_url('calendar/index'), array('method' => 'get')); ?>
            <div class="col-md-3">
                <label>Grupo Resolutor</label>
                <select name="g" id="g" class="form-control selectPequeno" >
                    <option value="">&lt; Seleccione Por Favor &gt;</option>
                    <?php
                    foreach ($groups as $group) { ?>
                        <option value="<?= $group['id'] ?>" <?php if ($group['id'] == $search_value) echo "selected" ?>><?= $group['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <span class="input-group-btn" style="padding-top: 25px !important;">
                    <button class="btn btn-default blue" type="submit">Buscar</button>
                </span>
            </div>
            <?php echo form_close(); ?>
        </div-->
  </div>
</div>
<br>

<body>
  <div id="calendar"></div>
</body>

<!-- Modal -->
<div id="createEventModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agendar</h4>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="inputPatient">Trabajo programado:</label>
          <div class="field desc">
            <input class="form-control" id="title" name="title" placeholder="Check list diario" type="text" value="">
          </div>
        </div>

        <input type="hidden" id="startTime" />
        <input type="hidden" id="endTime" />

        <div class="control-group">
          <!--label class="control-label" for="ticket">Ticket:</label-->
          <select class="controls controls-row" id="selectTickets" style="margin-top:5px;">
          </select>
        </div>

        <div class="control-group cuando">
          <label class="control-label" for="when">Cuando:</label>
          <div class="controls controls-row" id="when" style="margin-top:5px;">
          </div>
        </div>

        <table id="tableModalAsignar">

        </table>

      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Guardar</button>
      </div>
    </div>

  </div>
</div>


<div id="calendarModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalle</h4>
      </div>
      <div id="modalBody" class="modal-body">
        <h4 id="modalTitle" class="modal-title"></h4>
        <div id="modalWhen" style="margin-top:5px;"></div>

        <div class="form-group" style='display:none'>
          <div id='tecnicoAsignado' style='display:none'>
          </div>
          <label for="tec[id_mas_group]">Técnicos Disponibles:</label>
          <!-- <div class="container col-sm-3 col-md-3 col-xs-3" id="zona"> -->

          <select id="selectTecnico" name='ticket[tecnico]' class="form-control selectPequeno">
            <option value="">Seleccione un Técnico</option>
          </select>
          <?php echo form_error('ticket[tecnico]'); ?>
          <!-- </div> -->
        </div>

      </div>
      <input type="hidden" id="eventID" />
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <!--button type="submit" class="btn btn-danger" id="deleteButton">Eliminar</button-->
        <!--button type="submit" class="btn btn-primary" id="asignarButton">Asignar</button-->
      </div>
    </div>
  </div>
</div>
<!--Modal-->


<div class="modal fade" id="myModalfechaError" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Advertencia</h4>
      </div>
      <div class="modal-body">
        <p id="txtfechaIncorrecta"> La Hora no puede ser anterior a la hora actual </p>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAceptaAsig" class="btn btn-default" data-dismiss="modal">Aceptar</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="modal-overlay" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Cargando ...</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Se está realizando la operación, por favor espere.</p>
      </div>
      <div class="modal-footer justify-content-between">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div style='margin-left: auto;margin-right: auto;text-align: center;'>
</div>

<script type="text/javascript">
  var starTimeGlobal = '';
  var endTimeGlobal = '';
  var globalEvent = '';

  $(document).ready(function() {
    console.log('xxxxxx');




    console.log(lstCalendar);
    var calendar = $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month, agendaWeek,agendaDay,listMonth'
      },
      defaultView: 'agendaWeek',
      editable: true,
      selectable: true,
      //allDaySlot: false,
      businessHours: true, // display business hours           
      events: JSON.parse(lstCalendar),
      //eventColor: '#378006',


      eventClick: function(event, jsEvent, view) {

        console.log('eventClick')

        endtime2 = moment(event.end).format();
        starttime2 = moment(event.start).format();

        starTimeGlobal = starttime2;
        endTimeGlobal = endtime2;

        globalEvent = event;
        idEvent = event.id
        console.log(idEvent);
        tecnicos = getTecnicosDisponiblesAgenda(idEvent, starttime2, endtime2)
        //console.log(tecnicos);


        endtime = $.fullCalendar.moment(event.end).format('h:mm');
        starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');




        console.log(endtime);
        console.log(starttime);
        var mywhen = starttime + ' - ' + endtime;
        $('#modalTitle').html(event.title);
        $('#modalWhen').text(mywhen);
        $('#eventID').val(event.id);
        $('#calendarModal').modal();
      },

      //header and other values
      select: function(start, end, jsEvent) {
        console.log('select');

        var fechaFinal = new Date(start.format()).getTime();
        console.log(fechaFinal);


        fechaActual = new Date().getTime()
        console.log(fechaActual);
        dif = fechaFinal - fechaActual;
        console.log(dif / 60 / 60);
        // alert(event.title + " was dropped on " + event.start.format());

        if (dif < 0) {
          //alert('la fecha no es valida');

          $('#myModalfechaError').modal();
          revertFunc();
        } else {
          endtime = $.fullCalendar.moment(end).format('h:mm');
          starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
          var mywhen = starttime + ' - ' + endtime;
          start = moment(start).format();
          end = moment(end).format();

          TraerTickets();

          $('#createEventModal #startTime').val(start);
          $('#createEventModal #endTime').val(end);
          $('#createEventModal #when').text(mywhen);
          $('#createEventModal').modal('toggle');
        }
      },
      /*eventDrop: function(event, delta){  

         var title = $('#title').val();
         var startTime = $('#startTime').val();
         var endTime = $('#endTime').val();

         console.log('startTime'+startTime);
         console.log('startTime'+endTime);


        

         
         
         console.log('************');  
         console.log(event.start); 
         console.log(moment(event.start).format());
         console.log('*************');   
          
         postUrl =   "<?php //echo site_url('Calendar/update'); 
                      ?>";
          dataCliente = {
       'title' : event.title,   
       'start' : moment(event.start).format(),   
       'end' : moment(event.end).format(),   
       'id' : event.id,   
       };

       console.log(dataCliente);
          $.ajax({
              url: postUrl,
              data: dataCliente,
              type: "POST",
              success: function(json) {

               console.log(json);
              //alert(json);
              }
          });
      },*/

      eventDrop: function(event, dayDelta, revertFunc) {
        console.log('xxxxxxxxx');
        console.log(event.start.format());
        var fechaFinal = new Date(event.start.format()).getTime();
        console.log(fechaFinal);


        fechaActual = new Date().getTime()
        console.log(fechaActual);
        dif = fechaFinal - fechaActual;
        console.log(dif / 60 / 60);
        // alert(event.title + " was dropped on " + event.start.format());

        if (dif < 0) {
          //alert('la fecha no es valida');

          $('#myModalfechaError').modal();
          revertFunc();
        } else {

          var title = $('#title').val();
          var startTime = $('#startTime').val();
          var endTime = $('#endTime').val();

          console.log('startTime' + startTime);
          console.log('startTime' + endTime);






          console.log('************');
          console.log(event.start);
          console.log(moment(event.start).format());
          console.log('*************');

          postUrl = "<?php echo site_url('Calendar/update'); ?>";
          dataCliente = {
            'title': event.title,
            'start': moment(event.start).format(),
            'end': moment(event.end).format(),
            'id': event.id,
          };

          console.log(dataCliente);
          $.ajax({
            url: postUrl,
            data: dataCliente,
            type: "POST",
            success: function(json) {

              console.log(json);
              //alert(json);
            }
          });

        }


      },
      eventResize: function(event) {
        console.log('eventResize');
        postUrl = "<?php echo site_url('Calendar/update'); ?>";
        dataCliente = {
          'title': event.title,
          'start': moment(event.start).format(),
          'end': moment(event.end).format(),
          'id': event.id,
        };
        $.ajax({
          url: postUrl,
          data: dataCliente,
          type: "POST",
          success: function(json) {

            console.log(json);
            //alert(json);
          }
        });
      }
    });

    $('#submitButton').on('click', function(e) {
      console.log('submitButton')
      // We don't want this to act as a link so cancel the link action
      e.preventDefault();
      var ticketFormId = $("#ticketFormValue").val();
      //ticketFormId = ticketFormId.substring(0, ticketFormId.length -2);


      var idTicket = $('#selectTickets').val();
      var incident = $('#selectTickets option:selected').text();
      var idTech = $("#selecTecnico").val();

      var idForm = ticketFormId;
      var sla = '0';
      var slaArr = sla.split(" ");
      var address = $('#autocomplete').val();

      var zona = 10;
      // var team   = $('#selecTeam').val();
      var ciudad = 10;
      var sitio = 10;

      var idSitio = 10;

      var latGlobal = '';
      var lngGlobal = '';
      var latKeyGlobal = '';
      var lngKeyGlobal = '';

      var tecAcomp = $('#selecTecnicosMultiples').val();

      console.log($('#selecTecnicosMultiples').val());

      var res = $('#retreat').val();

      if (res == '1') {

        var streetkey = $('#streetkey').val();
        var commnetaryKey = $('#commnetaryKey').val();

      } else {
        var streetkey = '';
        var commnetaryKey = '';
      }
      console.log(idTicket + " -" + incident + "- " + latGlobal + "- " + lngGlobal + " -" + idTech + " -" + idForm + "- " + latKeyGlobal + "- " + lngKeyGlobal + "- " + tecAcomp);
      if (idTicket == undefined || incident == undefined || latGlobal == undefined || lngGlobal == undefined || idTech == '' || idForm == '' || tecAcomp == undefined) {
        swal("Mensaje SmartWay OyM!", "Todos los campos son obligatorios.", "warning")
      } else {
        $('#modal-overlay').modal({
          backdrop: 'static',
          keyboard: false
        });
        asignarTicket(idTicket, idTech, incident, slaArr[0], idForm, latGlobal, lngGlobal, address, streetkey, commnetaryKey, latKeyGlobal, lngKeyGlobal, ciudad, zona, idSitio[0], tecAcomp);
        doSubmit();
        $('#modal-overlay').modal('hide');
        $("#tableModalAsignar").html('');
      }



    });

    $('#asignarButton').on('click', function(e) {
      console.log('submitButton')
      // We don't want this to act as a link so cancel the link action
      e.preventDefault();
      doSubmitAsignar();
    });

    $('#deleteButton').on('click', function(e) {
      console.log('deleteButton')
      // We don't want this to act as a link so cancel the link action
      e.preventDefault();
      doDelete();
    });



    function doDelete() {
      console.log('doDelete');
      $("#calendarModal").modal('hide');
      var eventID = $('#eventID').val();
      $.ajax({
        url: 'index.php',
        data: 'action=delete&id=' + eventID,
        type: "POST",
        success: function(json) {
          if (json == 1)
            $("#calendar").fullCalendar('removeEvents', eventID);
          else
            return false;


        }
      });
    }

    function doSubmit() {
      console.log('doSubmit');


      $("#createEventModal").modal('hide');
      var title = $('#title').val();
      var startTime = $('#startTime').val();
      var endTime = $('#endTime').val();
      var incident = $('#selectTickets option:selected').text();


      $.ajax({
        //url: 'index.php',
        url: "<?php echo site_url('calendar/addEvent'); ?>",
        data: 'action=add&title=' + title + '&start=' + startTime + '&end=' + endTime + '&incident=' + incident,
        type: "POST",
        success: function(json) {
          $("#calendar").fullCalendar('renderEvent', {
              id: json.id,
              title: title,
              start: startTime,
              end: endTime,
            },
            true);
        }
      });

    }

    function doSubmitAsignar() {
      console.log('doSubmitAsignar');

      //console.log('action=add&title='+title+'&start='+startTime+'&end='+endTime);
      //$("#createEventModal").modal('hide');
      $("#calendarModal").modal('hide');
      var eventID = $('#eventID').val();
      var title = $('#title').val();
      var startTime = $('#startTime').val();
      var endTime = $('#endTime').val();
      var tecnico = $('#selectTecnico').val();

      //console.log(action=add&title='+title+'&start='+startTime+'&end='+endTime');

      console.log(starTimeGlobal);
      console.log(endTimeGlobal);
      //////////////////////////////////////////////////////////////////////
      postUrl = "<?php echo site_url('Calendar/asignarTicket'); ?>";
      dataAsignarTicket = {
        "idUser": tecnico,
        "idCalendar": eventID
      }
      console.log(dataAsignarTicket);
      $.ajax({
        //url: 'index.php',
        url: postUrl,
        data: dataAsignarTicket,
        type: "POST",
        success: function(json) {



          //globalEvent.title = "CLICKED!";
          globalEvent.color = '#257e4a'

          $('#calendar').fullCalendar('updateEvent', globalEvent);

          /*$("#calendar").fullCalendar('renderEvent',
             {
                 id: $('#eventID').val(),
                 title: $('#title').val(),
                 start: starTimeGlobal,
                 end: endTimeGlobal,
                 color: '#257e4a'
             },
             true); */
        }
      });

    }


    function TraerTickets() {
      console.log('Traer Tickets');

      postUrl = "<?php echo site_url('Calendar/getTickets'); ?>";
      $.ajax({
        type: "POST",
        url: postUrl,
        //data: dataLatLng,
        dataType: "text",
        success: function(result) {

          var dir = (JSON.parse(result));
          direcciones = dir;
          var html = "<select>"
          html += "<option value=''>Seleccione un ticket</option>";
          htmlm = '';
          for (var i = 0; i < dir.length; i++) {
            html += "<option value=" + dir[i].id + ">" + dir[i].incident + "</option>"
            htmlm += "<option value=" + dir[i].id + ">" + dir[i].incident + "</option>"
          }
          html += "<select>"

          $("#selectTickets").html(html);

          $('#selectTickets').select2({
            width: 450
          });




        },
        error: function(xhr, ajaxOptions, thrownError) {}
      });

    }


    $('body').on('change', '#selectTickets', function() {
      var incident = $('#selectTickets option:selected').text();
      //console.log(incident.options[incident.selectedIndex].text);
      dataUser = {
        "incident": incident
      };
      postUrl = "<?php echo site_url('Tracking/getViewAsignarTicket'); ?>";

      $.ajax({
        type: "POST",
        url: postUrl,
        data: dataUser,
        dataType: "text",
        success: function(result) {
          $("#tableModalAsignar").html(result).toggle().toggle();
          $("#ticketForm").parent().parent().css('display', 'none');
          $('#ticketFormValue').val('56##57##58##59##60')
          getdataTecnicos();

        },
        error: function(xhr, ajaxOptions, thrownError) {

        }
      });
    });


    function getdataTecnicos() {

      dataLatLng = {
        'direction': '',
        'cliente': '',
        'idZona': 10,
      };

      postUrl = "<?php echo site_url('Tracking/getTecnicoCoord'); ?>";
      $.ajax({
        type: "POST",
        url: postUrl,
        data: dataLatLng,
        dataType: "text",
        success: function(result) {

          var dir = (JSON.parse(result));
          direcciones = dir;
          var html = "<select>"
          html += "<option value=''>Seleccione un tecnico</option>";
          htmlm = '';
          for (var i = 0; i < dir.length; i++) {
            html += "<option value=" + dir[i].id + ">" + dir[i].name + "</option>"
            htmlm += "<option value=" + dir[i].id + ">" + dir[i].name + "</option>"
          }
          html += "<select>"

          $("#selecTecnico").html(html);



        },
        error: function(xhr, ajaxOptions, thrownError) {}
      });

      dataLatLng = {
        'direction': '',
        'cliente': '',
        'idZona': 10,
      };

      postUrl = "<?php echo site_url('Tracking/getTecnicoAcomp'); ?>";

      $.ajax({
        type: "POST",
        url: postUrl,
        data: dataLatLng,
        dataType: "text",
        success: function(result) {

          var dir = (JSON.parse(result));
          direcciones = dir;
          var html = "<select>"
          html += "<option value=''>Seleccione un tecnico</option>";
          htmlm = '';
          for (var i = 0; i < dir.length; i++) {
            html += "<option value=" + dir[i].id + ">" + dir[i].name + "</option>"
            htmlm += "<option value=" + dir[i].id + ">" + dir[i].name + "</option>"
          }
          html += "<select>"

          $("#selecTecnicosMultiples").html(htmlm);

          $('.multiple').multiselect();

        },
        error: function(xhr, ajaxOptions, thrownError) {}
      });


    }


    function asignarTicket(idTicket, idTech, incident, sla, idForm, latGlobal, lngGlobal, address, streetkey, commnetaryKey, latKeyGlobal, lngKeyGlobal, ciudad, zona, sitio, tecAcomp) {

      dataAsignarTicket = {
        "idTicket": idTicket,
        "idTech": idTech,
        "incident": incident,
        "idForm": idForm,
        "sla": sla,
        "lat": latGlobal,
        "lng": lngGlobal,
        "address": address,
        'streetkey': streetkey,
        'commnetaryKey': commnetaryKey,
        'latkey': latKeyGlobal,
        'lngkey': lngKeyGlobal,
        'ciudad': ciudad,
        'zona': zona,
        'sitio': sitio,
        'tecAcomp': tecAcomp
      }

      postUrl = "<?php echo site_url('Tracking/asignarTicket'); ?>";

      $.ajax({
        type: "POST",
        url: postUrl,
        data: dataAsignarTicket,
        dataType: "text",
        success: function(result) {
          console.log(result);
          if (result == "OK") {

            $('#txtAsignarTicket').text("Ticket Asignado Correctamente");
            $("#myModalAsignar").modal();
            /*var redirect = '<?php echo current_url(); ?>'
            location.href = redirect;
            window.location.href = redirect;*/
          } else {

            $('#txtAsignarTicket').text("Ha ocurrido un error");
            // $("#myModalAsignar").modal();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {

        }
      });
    }


  });

  function getTecnicosDisponiblesAgenda(idEvent, starttime2, endtime2) {
    postUrl = "<?php echo site_url('Calendar/getTecnicosDisponiblesAgenda'); ?>";
    dataTicket = {
      'idEvent': idEvent,
      'starttime': starttime2,
      'endtime': endtime2
    };
    $.ajax({
      url: postUrl,
      data: dataTicket,
      type: "POST",
      dataType: 'json',
      success: function(json) {
        console.log(json);
        tecnicos = json.tecnicos;
        tecnicoSelected = json.tecnico;
        console.log('tecnicoSelected')
        console.log(tecnicoSelected);
        //console.log(tecnicoSelected[0]);    
        //console.log(tecnicoSelected[0].id_user); 
        if (tecnicoSelected.length != 0) {
          var html2 = "<p>Ticket asignado a : " + tecnicoSelected[0].name + "</p>"
          $("#tecnicoAsignado").html(html2);
          $("#tecnicoAsignado").show();
        } else {
          var html2 = "<p>Ticket sin asignar</p>"
          $("#tecnicoAsignado").html(html2);
          $("#tecnicoAsignado").show();
        }





        var html = "<select>"
        html += "<option value=''> Seleccione un Técnico</option>"
        for (var i = 0; i < tecnicos.length; i++) {
          html += "<option value=" + tecnicos[i].id + ">" + tecnicos[i].name + "</option>"
        }
        html += "<select>"

        $("#selectTecnico").html(html);





        return json;
      }
    });

  }

  /* function asignarTicket(idTicket,idTech,incident){  /// deprecate

     dataAsignarTicket={ 
               "idTicket" : idTicket,
                 "idTech"    : idTech,
                 "incident"    : incident,
               }
     
     postUrl =   "<?php echo site_url('Calendar/asignarTicket'); ?>";
     console.log(dataAsignarTicket);
     //return;
   
     $.ajax({
               type: "POST",
               url: postUrl,
               data: dataAsignarTicket,
               dataType: "text",
               success: function(result) { 
           console.log("result asignarTicket");
           console.log(result);
           if(result == "OK"){
             console.log("redirec");
             //var redirect = '<?php //echo site_url('tracking/asignar'); 
                                ?>'; 
             // location.href = redirect; 
             //window.location.href = redirect;
             $('#txtAsignarTicket').text("Ticket Asignado Correctamente");
              $("#myModalAsignar").modal();
           }else{
             //console.log("mostrar error");
             $('#txtAsignarTicket').text("Ha ocurrido un error");
              $("#myModalAsignar").modal();
           }

          // $('#tableDetail').html(result);
               },
                 error: function(xhr, ajaxOptions, thrownError) {
                   
                 }
             });
   }*/


  //Función para los FormId

  function addForm(idForm) {

    var selectForm = $('#ticketFormValue').val();

    if (selectForm.length > 0) {
      var arrayForm = selectForm.split('##');
      var addFormId = false;
      var rmvFormId = false;

      for (var i = 0; i < arrayForm.length; i++) {
        if (idForm != arrayForm[i]) {
          addFormId = true;
        }
        if (idForm == arrayForm[i]) {
          rmvFormId = true;
        }
      }

      if (addFormId && rmvFormId == false) {
        var add = selectForm + idForm + '##';
        $('#ticketFormValue').val(add);
      }
      if (rmvFormId) {

        var remove = selectForm.replace(idForm + "##", "");
        $('#ticketFormValue').val(remove);
      }

    } else {
      $('#ticketFormValue').val(idForm + '##');
    }

  }
</script>