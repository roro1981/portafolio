<style type="text/css">
  .timeline::before {
    left: 0;
  }

  .jq-schedule .sc_bar {
    border: 1px solid;

  }

  .jq-schedule .sc_main_box {
    /* overflow-y: hidden!important;*/
  }

  .jq-schedule .sc_main_box,
  .jq-schedule .sc_data {
    max-height: 550px !important;

  }

  .jq-schedule .sc_main_scroll .sc_main .tl {
    /* height: 20000px!important;*/
  }

  .control-group {
    text-align: left;
  }

  .modal-content {
    min-width: 500px;
  }

  .timeline>div {
    margin-bottom: 0;
    margin-right: 0;
    position: static;

  }

  .green {
    background: green !important;
  }

  .red {
    background: red !important;
  }

  .yellow {
    background: yellow !important;
  }

  .green .ui-resizable-handle {
    background: green !important;
  }

  .red .ui-resizable-handle {
    background: red !important;
  }

  .yellow .ui-resizable-handle {
    background: yellow !important;
  }

  .timeline {
    margin-bottom: 0 !important;
  }



  <?php

  $p = date('H');
  $p = ($p + 2) * 6;
  for ($i = 1; $i <= 6; $i++) {
  ?>.tl:nth-child(<?php echo $p + $i; ?>) {
    background: rgba(34, 139, 34, 0.5) !important;

  }


  <?php
  }

  ?>
</style>
<?php echo form_open('calendar/control', array('id' => 'create-form'));   ?>
<div class="row">
  <div class="col-md-4" style="padding: 1em;">
    <div class="form-group">
      <label for="fechaentrega">Seleccione una fecha:</label>
      <input type="text" name="fechaentrega" id="fechaentrega" value="<?php echo $fechaentrega; ?>" class="form-control" readonly>
    </div>
  </div>
  <div class="col-md-2" style="padding: 3em;">
    <input type="submit" class="btn btn-primary" value="Buscar">
  </div>
</div>

<?php echo form_close();   ?>

<div id="schedule"></div>



<!-- Modal -->
<div id="createEventModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="inputPatient">Incidente:</label>
          <div class="field desc">
            <input class="form-control" id="incident" name="incident" placeholder="Check list diario" readonly type="text" value="">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPatient">CI:</label>
          <div class="field desc">
            <input class="form-control" id="ci" readonly name="ci" placeholder="Check list diario" type="text" value="">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPatient">Emplazamiento:</label>
          <div class="field desc">
            <input class="form-control" id="emplazamiento" readonly name="emplazamiento" placeholder="Check list diario" type="text" value="">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPatient">Alarma:</label>
          <div class="field desc">
            <input class="form-control" id="alarma" readonly name="alarma" placeholder="Check list diario" type="text" value="">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPatient">Estado:</label>
          <div class="field desc">
            <input class="form-control" id="estado" readonly name="estado" placeholder="Check list diario" type="text" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancelar</button>
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


<script src="<?php echo site_url('assets/js/jq.schedule.min.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '<',
      nextText: '>',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      weekHeader: 'Sm',
      //dateFormat: 'yy-mm-dd',
      dateFormat: 'dd-mm-yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    //$.datepicker.regional['es'] = {minDate: '0D', maxDate: '1M'};
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#fechaentrega').datepicker();


    //<?php echo str_replace(']', '', str_replace('[', '', $calendar)); ?>//
    var isDraggable = true;
    var isResizable = true;
    var $sc = $("#schedule").timeSchedule({
      startTime: "00:00", // schedule start time(HH:ii)
      endTime: "24:00", // schedule end time(HH:ii)
      widthTime: 60 * 10, // cell timestamp example 10 minutes
      timeLineY: 60, // height(px)
      verticalScrollbar: 20, // scrollbar (px)
      timeLineBorder: 4, // border(top and bottom)
      bundleMoveWidth: 8, // width to move all schedules to the right of the clicked time line cell
      draggable: isDraggable,
      resizable: isResizable,
      resizableLeft: true,
      rows: {
        <?php
        $x = 0;

        if ($calendar) {
          foreach ($calendar as $key) {

            echo "'" . $x . "' : JSON.parse('" . substr(json_encode($key), 1, -1) . "'),";
            $x++;
          }
        } 
        ?>
      },
      onChange: function(node, data) {
        //addLog('onChange', data);
      },
      onInitRow: function(node, data) {
        //addLog('onInitRow', data);
      },
      onClick: function(node, data) {
        console.log(data.data.type);

        $('#incident').val(data.data.incident);
        $('#ci').val(data.data.ci);
        $('#emplazamiento').val(data.data.emplazamiento);
        $('#estado').val(data.data.estado);
        $('#alarma').val(data.data.alarma);
        $('#createEventModal').modal('show');

      },
      onAppendRow: function(node, data) {
        //addLog('onAppendRow', data);
      },
      onAppendSchedule: function(node, data) {

      },
      onScheduleClick: function(node, time, timeline) {
        /*  var start = time;
          var end = $(this).timeSchedule('formatTime', $(this).timeSchedule('calcStringTime', time) + 3600);
          $(this).timeSchedule('addSchedule', timeline, {
              start: start,
              end: end,
              text:'Insert Schedule',
              data:{
                  class: 'sc_bar_insert'
              }
          });*/
      },
    });


    <?php
    $x = 0;
    foreach ($calendar as $key) {

      $x++;

      foreach ($key as $key2) {

        foreach ($key2['schedule'] as $key3) {


          $inc = $key3['text'];
          $class = $key3['class'];

    ?>

          $('.text:contains("<?php echo $inc; ?>")').parent().addClass('<?php echo $class; ?>');

    <?php
        }
      }
    }

    ?>



  });
</script>

<link href="<?php echo site_url('assets/css/style.min.css') ?>" rel="stylesheet">
</link>