


    $(document).ready(function() {
        //backbutton
        $('.btn-icon-back').click(function(){
            window.history.back();
        });
        
        // Clock code

        var $clockElement = $('#clock');

        function updateClock() {
            var now = new Date();
            var day = now.toLocaleDateString('fr-FR', { weekday: 'long' });
            var date = now.getDate();
            var month = now.toLocaleDateString('fr-FR', { month: 'long' });
            var hours = now.getHours();
            var minutes = now.getMinutes();

            $clockElement.text(day + ', ' + date + ' ' + month + ' ' + now.getFullYear() + ' ' + hours + ':' + (minutes < 10 ? '0' : '') + minutes);
        }

        updateClock(); // Initial call
        setInterval(updateClock, 1000); // Update clock every second

        // Calendar code
        const $calendar = $('#calendar');
        const $currentMonthElement = $('#currentMonth');
        const $prevMonthButton = $('#prevMonth');
        const $nextMonthButton = $('#nextMonth');
        const currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        const daysOfWeek = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];

        function renderCalendar(month, year) {
            $calendar.empty();
            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);
            const startingDayOfWeek = firstDayOfMonth.getDay();

            $currentMonthElement.text(months[month] + ' ' + year);

            // Render days of the week
            daysOfWeek.forEach(day => {
                $calendar.append('<span>' + day + '</span>');
            });

            // Render previous month's days if necessary
            for (let i = 0; i < startingDayOfWeek; i++) {
                const dateElement = $('<span></span>').text(lastDayOfMonth.getDate() - startingDayOfWeek + i + 1).addClass('calendar-day inactive');
                $calendar.append(dateElement);
            }

            // Render current month's days
            for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
                const dateElement = $('<span></span>').text(i).addClass('calendar-day');
                if (i === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
                    dateElement.addClass('today');
                }
                $calendar.append(dateElement);
            }
        }

        renderCalendar(currentMonth, currentYear);

        $prevMonthButton.on('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        $nextMonthButton.on('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });
       
           
            $('#calendarContainer').hide();;
        

        $('#transformButton').click(function() {
           
            $('#calendarContainer').toggle();;
        });
    
        function toggleVisibility() {
            $('.fixed-div, aside').toggleClass('show');
        }

        function toggleIconRectangleVisibility() {
            $('.icon-rectangle, .logo').toggleClass('show alternate-position');
        }

        $('.icon-rectangle').on('click', function(event) {
            // Ensure the target is exactly the .icon-rectangle and not a child element
            if (event.target === this) {
                toggleIconRectangleVisibility();
                toggleVisibility();
            }
            event.stopPropagation(); // Prevent click event from propagating to the document
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('').length) {
                $('.fixed-div, aside').removeClass('show');
                $('.icon-rectangle, .logo').removeClass('show alternate-position');
            }
        });
      
    });