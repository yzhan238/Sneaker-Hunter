<?php
	session_start();
        session_destroy();
?>
<script language="javascript">
alert('logged out');
document.location.href="/";
</script>
