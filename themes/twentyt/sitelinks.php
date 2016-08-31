<?php

$_PAGES = new Page();

$all_page = $_PAGES->get_all();

print '<nav>
			<ul>';
			foreach($all_page as $each){
					if($each->visibility==1){

						if(isset($_GET['page']) && $each->id==$_GET['page']){
							print "	<li class='selected'>";
						}
						else{
							print "	<li>";
							}

								if($each->parent==0){
									print "<a href='".UrlManager::seo_url($each->name)."'>".$each->name."</a>";
								}

								if(count($each->get_child_pages())!=0){
										
										print "<ul>";

										$child_pages = $each->get_child_pages();

										foreach($child_pages as $child){
											print "<li><a href='".UrlManager::seo_url($child->name)."'>".$child->name."</a></li>";
										}

										
										print "</ul>";

							print "</li>";


						}
					
					}
				}

print "		</ul>
		</nav>";


?>