$(document).ready(function(){
    $(document).on('change','#course', function(){
        
        var course_id = $(this).val();


        var div = $('#branch').parent();
        var op = "";
        $.ajax({
            type:'get',
            url:'{!!URL::to('staff/branch')!!}',
            data:{'id': course_id},
            success:function(data){
                console.log('success');
                console.log(data);
                console.log(data.length);
                op+='<option value="-1" disabled selected>Select Branch</option>';
                for(var i = 0;i<data.length;i++)
                {
                    op+='<option value="'+data[i].branchindex+'">'+data[i].name+'</option>';
                }

                div.find('#branch').html("");
                div.find('#branch').append(op);

            },
            error:function(){

            }
        });
        

        var d = $('#sem').parent();
        var  o = "";

        $.ajax({
            type:'get',
            url:'{!!URL::to('staff/sem')!!}',
            data:{'id': course_id},
            success:function(semData){
                console.log('success');
                console.log(semData);
                console.log(semData.length);
                o+='<option value="-1" disabled selected>Select Branch</option>';
                for(var i = 1;i<=semData.semesters;i++)
                {
                    o+='<option value="'+i+'">'+i+'</option>';
                }

                d.find('#sem').html("");
                d.find('#sem').append(o);

            },
            error:function(){

            }
        });
    });
});