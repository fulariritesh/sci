jQuery(function($){

    let offset = 0;
    let rejectOffset = 0;
    let findRejected = false;
    let pageSize = 6;
    const searchString = $('.resultlisting').data('text').replace('@@@', ' ');
    let totalShowingProfiles = 0;
    const $displayList = $('.displayList');
    const $searching = $('#searching');

    $.post({
        url: SEARCH_TALENT.request_url,
        data: {
            action: 'search',
            nonce: SEARCH_TALENT.nonce,
            offset: offset,
            rejectOffset: rejectOffset,
            pageSize: pageSize,
            searchString: searchString,
            findRejected: findRejected
        },
        success : function(res){
            UpdateList(JSON.parse(res));
        }
    });

    $('.resultlisting').on('click', '.loadMore button', function(){
       $(this).prop('disabled',true);
        $.post({
            url: SEARCH_TALENT.request_url,
            data: {
                action: 'search',
                nonce: SEARCH_TALENT.nonce,
                offset: offset,
                rejectOffset: rejectOffset,
                pageSize: pageSize,
                searchString: searchString,
                findRejected: findRejected
            },
            success : function(res){
                UpdateList(JSON.parse(res));
                $(this).prop('disabled',false);
            }
        });
    });

    function UpdateList(list){
        
        let usersList = list.userList ? list.userList[0] : [];

        if(list.offset){
            offset = list.offset;
        }
        

        if(list.findRejected){
            findRejected = list.findRejected;
        }
        
        usersList.forEach(profile => {
            let isProffessionCountMore = false;
            let listHtml = `<a href="${profile.href}" class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card h-100">
                        <img class="card-img-top" src=${profile.headshot} alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">${profile.display_name}</h5>
                            <p class="card-text"><i class="fas fa-map-marker-alt"></i> ${profile.location}</p>
                            <p>`;

                profile.professions.forEach((profession, index) => {
                    if(index > 3){
                        isProffessionCountMore = true;
                        return;
                    }
                    listHtml = listHtml + `<span class="badge categorybadge" style="background-color: ${profession.badgeColour};">`+profession.singularName+`</span>`;
                });
                
                if(isProffessionCountMore){
                    listHtml = listHtml + `<span class="badge categorybadge c-more">+${profile.professions.length - 4}</span>`;
                }

                listHtml = listHtml + `</p>
                        </div>
                        </div>
                    </a>`;

                $searching.hide();

                if($('#sitewide-search-header').length == 0){
                    $displayList.closest('.resultlisting').prepend($(`<div id="sitewide-search-header" class="row">
                    <div class="col-6 px-md-0">Showcasing India’s Talent Nationwide</div>
                    <div class="col-6 px-md-0 text-right">Showing <span id="totalCount"> </span> Results</div>
                    </div>`));
                }

                $displayList.append(listHtml);
                if(!list.isLast && $('.loadMore').length == 0){
                    $displayList.closest('.resultlisting')
                    .append($('<div class="loadMore text-center py-3"><button class="btn btn-md btn-full btn-primary px-5">Load More</button></div>'));
                }
                if(list.isLast){
                    $('.loadMore').hide();
                }
               
        });

        if(usersList.length == 0){
            $searching.hide();
            if(totalShowingProfiles > 0){
                $('.loadMore').hide();
            }else{
                $displayList.closest('.resultlisting').prepend($(`<div id="no-results" class="row">
                <div class="col-12 px-md-0">0 matching results found.</div>
                </div>`));
            }
            
        }else{
            totalShowingProfiles = totalShowingProfiles + list.totalCount;
            $('#totalCount').text(totalShowingProfiles);
        }
        

    }

});

