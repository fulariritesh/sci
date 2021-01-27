jQuery(function($) {

    let pageNumber = 1;
    let pageSize = 6;
    let totalMatchingProfiles = 0;
    let category = [];
    let displayingCategory = true;
    let mainCategory;

    $("#FT-subcategories").hide();

    $("#FT-allcategories").on('click','.actorCategory',function(){
        pageNumber = 1;
        category.push($(this).attr("id"));
        
        $.get('http://localhost:8080/wordpress/wp-json/sci/v1/sub-categories-data?pageNumber='+pageNumber+'&pageSize='+pageSize+'&category='+category[0], function(response){    
        console.log(response);    
        $('.displayList').empty();
            totalMatchingProfiles = response.totalCount;
            $('.totalCount').text(totalMatchingProfiles);   
            UpdateList(response.userList[0]);
            SubCategoryBlocks(response.subcategories);
            $("#FT-allcategories").hide();
            $("#FT-subcategories").show();
        });

    });

    $("#FT-subcategories").on('click','.actorSubCategory',function(){
        pageNumber = 1;
        
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
        
        $.get('http://localhost:8080/wordpress/wp-json/sci/v1/sub-categories-data?pageNumber='+pageNumber+'&pageSize='+pageSize+'&category='+categoryList, function(response){     
        $('.displayList').empty();
            totalMatchingProfiles = response.totalCount;
            $('.totalCount').text(totalMatchingProfiles);   
            UpdateList(response.userList[0]);
        });

    });

    $("#AllCategories").on('click',function(){
        $("#FT-allcategories").show();
        $("#FT-subcategories").hide();
        pageNumber = 1;
        category = [];
        displayingCategory = true;
        AllCategoryListing();
    });
    

    

    
    $('.resultlisting').on('click','.loadMore button',function(){
        let query;
        if(!category){
            query = 'http://localhost:8080/wordpress/wp-json/sci/v1/talent-data?pageNumber='+(++pageNumber)+'&pageSize='+pageSize;
        }else{
            query = 'http://localhost:8080/wordpress/wp-json/sci/v1/sub-categories-data?pageNumber='+(++pageNumber)+'&pageSize='+pageSize+'&category='+category.join();
        }

        $.get(query, function(response){
            UpdateList(response.userList[0]);            
        });
        
    });

    AllCategoryListing();

    function AllCategoryListing(){

        $.get({
            url: 'http://localhost:8080/wordpress/wp-json/sci/v1/talent-data?pageNumber='+pageNumber+'&pageSize='+pageSize, 
            cache: true
          }).then(function(response){
            UpdateList(response.userList[0]); 
            if(pageNumber == 1){
                CategoryBlocks(response.categories);
                totalMatchingProfiles = response.totalCount;
                $('.totalCount').text(totalMatchingProfiles);
            }
          });
    }

    function CategoryBlocks(categories){
        $('.category-blocks').empty();
        categories.forEach(category => {
            let listHtml = `<div class="col-6 col-lg-3 mb-2  px-0">
            <a href="#" class="actorCategory" id="`+category.id+`">
            <div class="row mx-1 shadow-sm ">
              <div class="col-4 py-2"><img src="`+category.image+`" alt="`+category.name+` Category" class="img-fluid" /></div>
              <div class="col-8 py-2 px-0">
                <span class="text-uppercase d-block">`+category.name+`</span>
                <span class="d-block cat-num">(`+category.count+`)</span>
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
            <a href="#" class="actorSubCategory" id="`+subcategory.id+`">
            <div class="row mx-1 shadow-sm ">
              <div class="col-4 py-2"><img src="`+subcategory.image+`" alt="`+subcategory.name+` Category" class="img-fluid" /></div>
              <div class="col-8 py-2 px-0 pt-4">
                <span class="text-uppercase">`+subcategory.name+`</span>
                <span class="cat-num"> (`+subcategory.count+`)</span>
              </div>
            </div>
          </a>
          </div>`;

            $('.sub-category-blocks').append(listHtml);
        });
    }

    function UpdateList(list){
        if(pageNumber == 1){
            $('.displayList').empty();
        }
        
        list.forEach(profile => {
            let isProffessionCountMore = false;
            let listHtml = `<a href="/wordpress/profile/`+profile.ID+`" class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card h-100">
                        <img class="card-img-top" src=`+profile.headshot+` alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">`+profile.display_name+`</h5>
                            <p class="card-text"><i class="fas fa-map-marker-alt"></i> `+profile.location+`</p>
                            <p>`;

                profile.professions.forEach((profession, index) => {
                    if(index > 3){
                        isProffessionCountMore = true;
                        return;
                    }
                    listHtml = listHtml + `<span class="badge c-`+profession.toLowerCase().replace(' ','-')+`">`+profession+`</span>`;
                });
                
                if(isProffessionCountMore){
                    listHtml = listHtml + `<span class="badge c-more">+2</span>`;
                }

                listHtml = listHtml + `</p>
                        </div>
                        </div>
                    </a>`;

            $('.displayList').append(listHtml);

            if($('.displayList a').length == totalMatchingProfiles){
                $('.loadMore button').prop('disabled', true);
            }else{
                $('.loadMore button').prop('disabled', false);
            }
        });
    }

    
});