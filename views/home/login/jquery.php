<script type="text/javascript">
    $(document).ready(function() {
        Init();
    });
    function Init()
    {
        $('#user_id').focus();
    }
    function checkLogin()
    {
        if($('#user_id').val() != '')
        {
            if($('#user_pw').val() != '')
            {
                var result = getAjax('login/check', 'post', {user_id : $('#user_id').val(), user_pw : $('#user_pw').val()}).responseText;
                result = JSON.parse(result);
                if(result.result == true)
                {
                    location.href='/';
                }
                else
                {
                    alert('로그인 정보가 없습니다.');
                    $('#user_id').focus();
                }
            }
            else
            {
                alert('비밀번호를 입력해주세요');
                $('#user_pw').focus();
            }
        }
        else
        {
            alert('아이디를 입력해주세요');
            $('#user_id').focus();
        }
    }
    function keypress(event)
    {
        if(event.keyCode == 13)
        {
            checkLogin();
        }
    }

</script>