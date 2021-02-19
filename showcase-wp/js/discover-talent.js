jQuery(function($) {
    // const baseUrl = '/wp-json/sci/v1/';
    const baseUrl = '/sci/wp-json/sci/v1/';
    const endpoint = 'talent-data';
    let pageNumber = 1;
    let pageSize = 6;
    let totalMatchingProfiles = 0;
    let category = [0];
    let displayingCategory = true;
    let mainCategory;
    let location = '-1';
    let gender = '-1';
    let age = '-1';
    let noResultsWithAdvanceFilter = false;
    let advanceSearch = false;

    const $noSerchResultDiv = $('#no-search-results');
    const $btnAdvanceSearch = $('#advance-search');
    const $divAllCategories = $("#FT-allcategories");
    const $divAllSubCategories = $("#FT-subcategories");
    const $totalCount = $('.totalCount');
    const $displayList = $('.displayList');
    const $btnLoadMore = $('.loadMore button');

    $noSerchResultDiv.hide();
    $btnLoadMore.prop('disabled', true);
    $divAllSubCategories.hide();


    $divAllCategories.on('click','.actorCategory',function(){
        $divAllCategories.find('.actorCategory').find('.row.shadow-sm').removeClass('selected-subcategory');
        $highlightedBlock = $(this).find('.row.shadow-sm');
        $highlightedBlock.addClass('selected-subcategory');
        pageNumber = 1;
        $noSerchResultDiv.hide();
        noResultsWithAdvanceFilter = false;
        advanceSearch = false;
        $btnAdvanceSearch.prop('disabled', false);
        category[0] =$(this).attr("id");
        $('#subcategory-type').text($(this).data("singular-name"));
        
        $.get(`${baseUrl}${endpoint}?pageNumber=${pageNumber}&pageSize=${pageSize}&category=${category[0]}&location=${location}&gender=${gender}&age=${age}`, function(response){       
            if(response.result == 0){
                $highlightedBlock.removeClass('selected-subcategory');
                $displayList.empty();
                totalMatchingProfiles = response.totalCount;
                $totalCount.text(totalMatchingProfiles);   
                UpdateList(response.userList[0]);
                SubCategoryBlocks(response.categories);
                $divAllCategories.hide();
                $divAllSubCategories.show();
            }else if(response.result == 1){
                noResultsFoundWithFilters(response);
            }else{
                noResultsFound(response);
            }
        });

    });

    $divAllSubCategories.on('click','.actorSubCategory',function(){
        pageNumber = 1;
        $noSerchResultDiv.hide();
        noResultsWithAdvanceFilter = false;
        advanceSearch = false;
        $btnAdvanceSearch.prop('disabled', false);
        
        $(this).find('.row.shadow-sm').toggleClass('selected-subcategory');
        
        if(displayingCategory){
            mainCategory = category[0];
            category = [];
            displayingCategory = false;
        }

        if($(this).find('.row.shadow-sm').hasClass('selected-subcategory')){
            category.push($(this).attr("id"));
        }else{
            category.splice( $.inArray($(this).attr("id"), category), 1 );
        }

        let categoryList;
        if(jQuery.isEmptyObject(category)){
            category[0] = mainCategory;
            categoryList = mainCategory;
            displayingCategory = true;
        }else{
            categoryList = category.join();
        }
        
        $.get(`${baseUrl}${endpoint}?pageNumber=${pageNumber}&pageSize=${pageSize}&category=${categoryList}&location=${location}&gender=${gender}&age=${age}`, function(response){     
            if(response.result == 0){
                $displayList.empty();
                totalMatchingProfiles = response.totalCount;
                $totalCount.text(totalMatchingProfiles);   
                UpdateList(response.userList[0]);
            }else if(response.result == 1){
                noResultsFoundWithFilters(response);
            }else{
                noResultsFound(response);
            }
        });

    });

    $btnAdvanceSearch.on('click',function(){
        pageNumber = 1;
        $noSerchResultDiv.hide();
        advanceSearch = true;
        $btnAdvanceSearch.prop('disabled', false);
        $.get(`${baseUrl}${endpoint}?pageNumber=${pageNumber}&pageSize=${pageSize}&category=${category.join()}&location=${location}&gender=${gender}&age=${age}`, function(response){       
            if(response.result == 0){
                $displayList.empty();
                totalMatchingProfiles = response.totalCount;
                $totalCount.text(totalMatchingProfiles);   
                UpdateList(response.userList[0]);
            }else if(response.result == 1){
                noResultsFoundWithFilters(response);
            }else{
                noResultsFound(response);
            }
                
        });
    });

    $('#loaction').on('change', function(e) {
        location = this.options[e.target.selectedIndex].value;
    });

    $('#gender').on('change', function(e) {
        gender = this.options[e.target.selectedIndex].value;
    });

    $('#age').on('change',function(e){
        age = this.options[e.target.selectedIndex].value;
    })

    $("#AllCategories").on('click',function(){
        $noSerchResultDiv.hide();
        $btnAdvanceSearch.prop('disabled', false);
        $divAllCategories.show();
        $divAllSubCategories.hide();
        pageNumber = 1;
        category = [0];
        categoryList = '';
        displayingCategory = true;
        noResultsWithAdvanceFilter = false;
        advanceSearch = true;
        AllCategoryListing();
    });

    $('.resultlisting').on('click','.loadMore button',function(){
        if(noResultsWithAdvanceFilter){
            query = `${baseUrl}${endpoint}?pageNumber=${++pageNumber}&pageSize=${pageSize}&category=${category.join()}`;
            $.get(query, function(response){
                UpdateList(response.userList[0]);            
            });
        }else{
            query = `${baseUrl}${endpoint}?pageNumber=${++pageNumber}&pageSize=${pageSize}&category=${category.join()}&location=${location}&gender=${gender}&age=${age}`;
            $.get(query, function(response){
                UpdateList(response.userList[0]);            
            });
        }
        
    });

    AllCategoryListing();

    function AllCategoryListing(){

        $.get({
            url: `${baseUrl}${endpoint}?pageNumber=${pageNumber}&pageSize=${pageSize}&location=${location}&gender=${gender}&age=${age}`, 
            cache: true
          }).then(function(response){
            if(response.result == 0){
                if(pageNumber == 1){
                    CategoryBlocks(response.categories);
                    totalMatchingProfiles = response.totalCount;
                    $totalCount.text(totalMatchingProfiles);
                }
                UpdateList(response.userList[0]); 
            }else if(response.result == 1){
                noResultsFoundWithFilters(response);
            }else{
                noResultsFound(response);
            }
          });
    }

    function noResultsFoundWithFilters(response){
        $noSerchResultDiv.show();
        $totalCount.text(0);
        if(pageNumber == 1){
            $displayList.empty();
        }
        query = `${baseUrl}${endpoint}?pageNumber=${pageNumber}&pageSize=${pageSize}&category=${category.join()}`;
        $.get(query, function(response){
            if(response.result == 2){
                $displayList.text(response.text);
                $btnLoadMore.prop('disabled', true);
            }else{
                $displayList.empty();  
                totalMatchingProfiles = response.totalCount;
                noResultsWithAdvanceFilter = true;
                UpdateList(response.userList[0]);
                
                if(displayingCategory && !advanceSearch){
                    $divAllCategories.hide();
                    $divAllSubCategories.show();
                    SubCategoryBlocks(response.categories);
                    
                }
            }
                    
        });
    }

    function noResultsFound(response){
        $btnLoadMore.prop('disabled', true);
        $totalCount.text(0);
        $displayList.text(response.text);
        $btnAdvanceSearch.prop('disabled', true);
    }

    function CategoryBlocks(categories){
        $('.category-blocks').empty();
        categories.forEach(category => {
            let listHtml = `<div class="col-6 col-lg-3 mb-2  px-0">
            <a href="#" class="actorCategory" id="${category.id}" data-singular-name="${category.singularName}">
            <div class="row mx-1 shadow-sm ">
              <div class="col-4 py-2"><img src="${category.image}" alt="${category.name} Category" class="img-fluid" /></div>
              <div class="col-8 py-2 px-0">
                <span class="text-uppercase d-block">${category.name}</span>
                <span class="d-block cat-num">(${category.count})</span>
              </div>
            </div>
          </a>
          </div>`;

            $('.category-blocks').append(listHtml);
        });
    }

    function SubCategoryBlocks(subcategories){
        $('.sub-category-blocks').empty();
        subcategories.forEach(subcategory => {
            let listHtml = `<div class="col-6 col-lg-3 mb-2  px-0">
            <a href="#" class="actorSubCategory" id="${subcategory.id}">
            <div class="row mx-1 shadow-sm ">
              <div class="col-4 py-2"><img src="${subcategory.image}" alt="${subcategory.name} Category" class="img-fluid" /></div>
              <div class="col-8 py-2 px-0 pt-4">
                <span class="text-uppercase">${subcategory.name}</span>
                <span class="cat-num"> (${subcategory.count})</span>
              </div>
            </div>
          </a>
          </div>`;

            $('.sub-category-blocks').append(listHtml);
        });
    }

    function UpdateList(list){
        if(pageNumber == 1){
            $displayList.empty();
        }
        
        list.forEach(profile => {
            let isProffessionCountMore = false;
            let listHtml = `<a href="${profile.href}" class="col-6 col-sm-4 col-md-3 col-lg-2" data-status="${profile.accountIsActive}">
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

                    $displayList.append(listHtml);

                    let a = $displayList.find('a[data-status="0"]');
                    a.remove();
                    $displayList.append(a);
        });

        if($('.displayList a').length == totalMatchingProfiles){
            $btnLoadMore.prop('disabled', true);
        }else{
            $btnLoadMore.prop('disabled', false);
        }
    }

    
});
