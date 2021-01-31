jQuery(function($) {

    var pageSize = 6;
    var pageNumber = 1;
    var setTotalCount = true;

        var data = {
            'action': 'load_matching_talents_by_ajax',
            'pageSize': pageSize,
            'pageNumber': pageNumber,
            'security': discover.security
        }

        $.post(discover.ajaxurl, data, function(response) {
            setTotalCount = true;
            if(response == 'No matching talents found.'){
                $('.loadMore.btn').prop( "disabled", true );
                setTotalCount = false;
                $('.totalCount').text('0');
            }
            
            $('.displayList').html(response);
            updateScreen(response);
            
        });


        //get total matching profiles count
        var countData = {
            'action': 'get_matching_talents_count_by_ajax',
            'security': discover.security
        }

        $.post(discover.ajaxurl, countData, function(response) {
            if(setTotalCount){
                $('.totalCount').text(response);
            }
        });

        //Update screen with new records
        function updateScreen(response){
            $('.showingCount').text($('.displayList').children('a').length);

            if($('.totalCount').text() == $('.showingCount').text()){
                $('.loadMore.btn').prop( "disabled", true );
            }
        }

    $('.resultlisting').on('click','.btn.loadMore',function(){
        
        var data = {
            'action': 'load_matching_talents_by_ajax',
            'pageSize': pageSize,
            'pageNumber': ++pageNumber,
            'security': discover.security
        }

        $.post(discover.ajaxurl, data, function(response) {
            $('.displayList').append(response);
            updateScreen(response);
        });

    });
});