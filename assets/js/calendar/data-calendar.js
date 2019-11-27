document.addEventListener('DOMContentLoaded', function() {
    /* var events = listTask;
    var eventsArray = [];
    
    events.forEach(function(element, index){
         eventsArray.push({
            title:element.subject,
            project : element._links.project.title,
            status: element._links.status.title,
            start:element.startDate,
            end:element.dueDate,
            assignee: element._links.assignee.title,
            priority: element._links.priority.title,
            description:element.description.raw,
            startDate: element.startDate,
            finishDate: element.dueDate
         })
    })
    console.log(eventsArray) */


    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
    
          /* header of calender. Not delete */
           header: {
            left: 'prev',
            center: 'title',
            right: 'next'
          },

          defaultDate: Date.now(),
          navLinks: true, // can click day/week names to navigate views
          selectable: true,
          selectMirror: true,
         /*  select: function(arg) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.addEvent({
                title: title,
                start: arg.start,
                end: arg.end,
                allDay: arg.allDay
              })
            }
            calendar.unselect()
          }, */
          editable: true,
          eventLimit: true, // allow "more" link when too many events,
          events: eventsArray,
         
          eventMouseEnter: function (data, event, view) {
            tooltip = '<div class="tooltiptopicevent" '+
              'style="width:186px;height:auto;background:#fff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  '+
              'border-radius: 6px;'+
              'box-shadow: 0 10px 20px 0 rgba(0, 0, 0, 0.2);'+
              'border: solid 1px #fff;'+
              'line-height: 1.5; font-size: 14px;">' +
              data.event._def.extendedProps.type + ' #' + data.event.id + ' : ' + data.event.title + '</br>' +
              'Project: ' + data.event._def.extendedProps.project + '</br>' + 
              'Status: ' + data.event._def.extendedProps.status + '</br>' + 
              'Start date: '  + data.event._def.extendedProps.startDate + '</br>'+
              'Finish date: ' +  data.event._def.extendedProps.finishDate + '</br>'+
              'Assignee: ' + (data.event._def.extendedProps.assignee != undefined ? data.event._def.extendedProps.assignee : "-") + '</br>' + 
              'Priority: ' + data.event._def.extendedProps.priority  
              '</div>';

            $("body").append(tooltip);
            $("body").mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });


        },
        eventMouseLeave: function (data, event, view) {
            $(this).css('z-index', 8);
    
            $('.tooltiptopicevent').remove();
    
        },
        dayClick: function () {
            tooltip.hide()
        },
        eventResizeStart: function () {
            tooltip.hide()
        },
        eventDragStart: function () {
            tooltip.hide()
        },
        viewDisplay: function () {
            tooltip.hide()
        },
    
        });
    
        calendar.render();

});