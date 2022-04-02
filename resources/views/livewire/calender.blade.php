<div>



    <div class="container">
        <h3 class="margin_10px">Agenda</h3>
        <h6 class="margin_10px">Veja a nossa Agenda completa e marque um horário para a sua consulta, agendar uma consulta, você deve se registrar ou usar uma conta existente.</h6>
        <div class="margin_top" id='calendar_id'></div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="schedule-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nova Consulta</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form>

                        <div class="form-group">
                            <label>Titulo:</label>
                            <input type="text" class="form-control" wire:model="title">
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" wire:click="event_create()">Addicionar Consulta</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#calendar_id').fullCalendar({
                editable:true,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay'
                },
                defaultView: 'agendaWeek',
                // events: SITEURL + "/calendar",
                events: function(start, end, timezone, callback) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                         type: 'GET',
                         url: SITEURL + "/calender",
                         data: {
                             start: start,
                             end: end,
                         },
                         dataType: 'json',
                         success: function(data) {
                             var events = [];
                             $(data).each(function() {
                                 events.push({
                                     id: $(this).attr('id'),
                                     title: $(this).attr('title'),
                                     start: $(this).attr('start_date'),
                                     end: $(this).attr('end_date'),
                                 });
                             });
                             callback(events);
                         },
                         error : function(data) {
                             alert("Falha ao carregar a agenda");
                             return false;
                         },
                     });
                },
                displayEventTime: false,
                editable: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                eventClick: function (event) {
                    var deleteMsg = confirm("Do you really want to delete this event?");
                    if (deleteMsg) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/agenda/ajax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event successfully deleted!");
                            }
                        });
                    }
                },
                dayClick: function(date, jsEvent, view) {

                    $('#schedule-add').modal('show');
                    /* var title = "ok funcionou";
                     var start = date;
                     var end = date;

                     if (title) {
                         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                         $.ajax({
                             url: SITEURL + "/calender/ajax",
                             data: {
                                 patient_id: 1,
                                 title: title,
                                 start: start,
                                 end: end,
                                 type: 'add'
                             },
                             type: "POST",
                             success: function (data) {
                                 displayMessage("Event successfully created!");
                                 calendar.fullCalendar('renderEvent',{
                                     id: data.id,
                                     patient_id: 1,
                                     title: title,
                                     start: start,
                                     end: end,
                                     allDay: allDay
                                 },true);
                                 calendar.fullCalendar('unselect');
                             }
                         });
                     }
                     */
                }

            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</div>

