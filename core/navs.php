<?php

return [
            ["name" => "<span class='glyphicon glyphicon-th-large' aria-hidden='true'></span> ".$language['dashboard'],"link" => "admin/dashboard/","class" => "active"],
                  
            ["name" => $language['news'],"link" => "#","permission" => 'blogpost',"childs" => [
                                                                                  ["name" => "<i class='fa fa-newspaper-o'></i> " .$language['posted_news'],"link" => "admin/blogpost/"],
                                                                                  ["name" => "<i class='fa fa-pencil'></i> " .$language['create_post'],"link" => "admin/blogpost/newpost"],
                                                                                  //["name" => "Comments","link" => "admin/blogpost/comment"],
                                                                                  ["name" => "<i class='fa fa-list-ul'></i> " .$language['categories'],"link" => "admin/blogpost/category"],
                                                                                ]
                                                                            ],
            ["name" => $language['users'],"link" => "#","permission" => 'user', "childs" => [
                                                                ["name" => "<i class='fa fa-users'></i> " .$language['user_list'],"link" => "admin/user"],
                                                                ["name" => "<i class='fa fa-user-plus'></i> " .$language['add_user'],"link" => "admin/user/add"],
                                                                ["name" => "<i class='fa fa-gavel'></i> " .$language['user_groups'],"link" => "admin/usergroup"],
                                                              ]
                                                        ],
            ["name" => $language['pages'],"link" => "#","permission" => 'page', "childs" => [
                                                                ["name" => "<i class='fa fa-files-o'></i> " .$language['page_list'],"link" => "admin/page"],
                                                                ["name" => "<i class='fa fa-pencil-square-o'></i> " .$language['add_page'],"link" => "admin/page/create"],  
                                                              	["name" => "<i class='fa fa-file-text-o' aria-hidden='true'></i> ".$language['static_pages'], "link" => "admin/page/staticpages" ], 

                                                              ]
                                                      ],
            ["name" => $language['media'],"link" => "#", "permission" => 'media',"childs" => [
                                                                  ["name" => "<i class='fa fa-picture-o'></i> " .$language['header_images'],"link" => "admin/headerimages"],
                                                                  ["name" => "<i class='fa fa-folder-open-o'></i> " .$language['files'],"link" => "admin/filemanager"],
                                                                  ["name" => "<i class='fa fa-camera-retro'></i> " .$language['gallery'],"link" => "admin/gallery"],
                                                                  
                                                                ]
                                                    ],
            ["name" => $language['themes_apps'],"link" => "#","permission" => 'themes&apps', "childs" => [
                                                                  ["name" => "<i class='fa fa-desktop'></i> " .$language['themes'], "link" => "admin/theme"],
                                                                  ["name" => "<i class='fa fa-cubes'></i> " .$language['plugins'],"link" => "admin/plugin/"],
                                                                  ["name" => "<i class='fa fa-code'></i> " .$language['develop'], "link" => "admin/develop"],
                                                                ]
                                                            ],
                  ];