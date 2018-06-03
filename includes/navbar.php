<div class="row clearfix">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><img src="img/logo.png" style="width:25px; height:25px;"> Empire Web</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php
					if(isset($_SESSION['empire_ip']) && isset($_SESSION['empire_port']) && isset($_SESSION['empire_user']) && isset($_SESSION['empire_pass']) && isset($_SESSION['empire_session_token']) && isset($_SESSION['csrf_token']))
					{
					echo '<li>
						<a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a>
					</li>
					<li class="dropdown">
						<a  href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-transfer"></span> Listeners <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
							<li>
								<a href="show-all-listeners.php">Show All Listeners</a>
							</li>
                            <li>
								<a href="search-listener-name.php">Search Listener by Name</a>
							</li>
                            <li>
								<a href="create-listener.php">Create a Listener</a>
							</li>
                            <li>
								<a href="kill-listener.php">Kill Listener(s)</a>
							</li>
                        </ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-heart"></span> Stagers <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
							<li>
								<a href="show-all-stagers.php">Show All Stagers</a>
							</li>
                            <li>
								<a href="search-stager-name.php">Search Stager by Name</a>
							</li>
                            <li>
								<a href="generate-stager.php">Generate Stager</a>
							</li>
                        </ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-screenshot"></span> Agents <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
							<li>
								<a href="show-all-agents.php">Show All Agents</a>
							</li>
                            <li>
								<a href="search-agent-name.php">Search Agent by Name</a>
							</li>
                            <li>
								<a href="show-stale-agents.php">Show Stale Agents</a>
							</li>
                            <li>
								<a href="remove-stale-agents.php">Remove Stale Agents</a>
							</li>
                            <li>
								<a href="remove-agent.php">Remove Agent</a>
							</li>
                            <li>
								<a href="agent-shell-cmd.php">Agent - Run Shell Command</a>
							</li>
                            <li>
								<a href="show-agent-results.php">Show Agent Results</a>
							</li>
                            <li>
								<a href="delete-agent-results.php">Delete Agent Results</a>
							</li>
                            <li>
								<a href="clear-agent-task-queue.php">Clear Queued Agent Tasking</a>
							</li>
                            <li>
								<a href="rename-agent.php">Rename Agent</a>
							</li>
                            <li>
								<a href="kill-agent.php">Kill Agent(s)</a>
							</li>
							<li>
								<a href="show-agent-screenshots.php">View Screenshots</a>
							</li>
							<li>
								<a href="show-agent-webcam.php">View Webcam Videos</a>
							</li>
                        </ul>
					</li>
                    <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Modules <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
							<li>
								<a href="show-all-modules.php">Show All Modules</a>
							</li>
                            <li>
								<a href="search-module-name.php">Show Module by Name</a>
							</li>
                            <li>
								<a href="search-module.php">Search for Module</a>
							</li>
                            <li>
								<a href="execute-module.php">Execute Module</a>
							</li>
                        </ul>
					</li>
                    <li>
						<a href="credentials.php"><span class="glyphicon glyphicon-flag"></span> Credentials</a>
					</li>
                    <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-eye-open"></span> Reporting <strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
							<li>
								<a href="show-all-logged-events.php">All Logged Events</a>
							</li>
                            <li>
								<a href="show-logged-events-agent.php">Agent Logged Events</a>
							</li>
                            <li>
								<a href="show-logged-events-type.php">Logged Events - Type</a>
							</li>
                            <li>
								<a href="show-logged-events-msg.php">Logged Events - Msg</a>
							</li>
                        </ul>
					</li>
                    <li>
						<a href="browser.php"><span class="glyphicon glyphicon-globe"></span> Browser</a>
					</li>';
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if(isset($_SESSION['empire_ip']) && isset($_SESSION['empire_port']) && isset($_SESSION['empire_user']) && isset($_SESSION['empire_pass']) && isset($_SESSION['empire_session_token']) && isset($_SESSION['csrf_token']))
					{
						echo '<li class="dropdown">
						 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> '.htmlentities($_SESSION['empire_user']).' <strong class="caret"></strong></a>
						<ul class="dropdown-menu">
							<li>
								<a href="version.php"><span class="glyphicon glyphicon-tower"></span> Version</a>
							</li>
                            <li>
								<a href="configuration.php"><span class="glyphicon glyphicon-cog"></span> Configuration</a>
							</li>
                            <li>
								<a href="administration.php"><span class="glyphicon glyphicon-fire"></span> Administration</a>
							</li>
							<li class="divider">
							</li>
                            <li>
								<a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> About</a>
							</li>
							<li>
								<a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a>
							</li>
						</ul>
					</li>';
					}
					else
					{
						echo '<li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Login</a></li><li><a href="about.php"><span class="glyphicon glyphicon-cog"></span> About</a></li>';
					}
					?>
				</ul>
			</div>
			
		</nav>
	</div>
</div><br><br><br>
