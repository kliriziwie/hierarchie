<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>JavaScript Shield UI Demos</title>
    <link id="themecss" rel="stylesheet" type="text/css" href="//www.shieldui.com/shared/components/latest/css/light/all.min.css" />
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">

</head>
<body class="theme-light">
<!-- <link rel="stylesheet" href="http://demos.shieldui.com//Content/fonts/font-awesome/css/font-awesome.min.css" />-->
<div class="container">
    <div id="treeview"></div>
    <div class="tag-container">
        <span id="trashCan" class="fa fa-trash item-trash"></span>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        $("#treeview").shieldTreeView({
			textTemplate: "{Name}",
            hasChildrenTemplate: "{HasChildren}",
            dragDrop: true,
            dragDropScope: "treeview-dd-scope",
            dataSource: new shield.RecursiveDataSource({
                remote: {
                    read: function (params, success, error, extra) {
                        if (!extra) {
                            // if no extra params provided, it means
                            // this is a read for the top level item
                            $.ajax({
                                url: "getTreeApi.php?old=<?php echo(isset($_REQUEST['old'])?$_REQUEST['old']:0);?>"
                            }).done(function (data) {
								console.log("Hier kommt der Success");
                                success(data, false, extra);
                            }).fail(function () {
                                success([], false, extra);
                            });
                        }
                        else {
                            // there is a parent, so get its items from its
                            // ChildrenUrl property
                            $.ajax({
                                url: extra.parent.ChildrenUrl
                            }).done(function (data) {
                                success(data, false, extra);
                            }).fail(function () {
                                success([], false, extra);
                            });
                        }
                    }
                }
            }),
            events: {
                droppableOver: function(e) {
                    if (!e.valid) {
                        // if an invalid draggable item is over a tree item,
                        // re-validate it - i.e. if it is a doc-item, allow the drop
                        if ($(e.draggable).hasClass('doc-item')) {
                            e.valid = true;
                        }
                    }
                },
                drop: function (e) {
					sourceId = this.getItem(this.getPath(e.sourceNode)).id;
					console.log(sourceId);
					targetId = this.getItem(this.getPath(e.targetNode)).id;
					console.log(targetId);
					
					sourceKind = this.getItem(this.getPath(e.sourceNode)).kind;
					console.log("sourcekind: "+sourceKind);
					
					targetKind = this.getItem(this.getPath(e.targetNode)).kind;
					
					
					console.log("targetKind: "+targetKind);
					
                    var valid = e.valid;
                    if (!valid) {
                        // if not valid, it means something different than a tree node
                        // is being dropped - in this case, check for a doc item and 
                        // set valid to true if so
                        if ($(e.draggable).hasClass('doc-item')) {
                            valid = true;
                        }
                    }
                    if (valid) {
                        if (e.sourceNode) {
							
							if(sourceKind  == "category"  && targetKind == "category") {
								console.log("Moving Category");
                                // dropping a treeview node - move it
                                this.append(e.sourceNode, e.targetNode);
							    $.ajax({
                                    url: "updateTree.php",
								    data: {"sourceId": sourceId, "targetId": targetId}
                                }).done(function (data) {
                               
                                }).fail(function () {
                                
                                });
						    } else if(sourceKind == "leave" && targetKind == "category") {
								console.log("Monving Leave");
								 this.append(e.sourceNode, e.targetNode);
							    $.ajax({
                                    url: "updateLeave.php",
								    data: {"sourceId": sourceId, "targetId": targetId}
                                }).done(function (data) {
                               
                                }).fail(function () {
                                
                                });
								
						    } else {
								console.log("Mving Nothing");
						    }
                        }
                        else {
                            // dragging a doc item - insert a new one
                            // and remove the dragged element
                            this.append({ text: $(e.draggable).html() }, e.targetNode);
                            $(e.draggable).remove();
                        }
                        // disable the animation
                        e.skipAnimation = true;
                    }
                }
            }
        });
        // setup drag and drop handlers for the elements outside the treeview
        $(".doc-item").shieldDraggable({
            scope: "treeview-dd-scope",
            helper: function() { 
                return $(this.element).clone().appendTo(document.body);
            },
            events: {
                stop: function (e) {
                    // always cancel the movement of the item;
                    // if a drop over a valid target ocurred, we will handle that 
                    // in the respective drop handler
                    e.preventDefault();
                }
            }
        });
        // handle drop on the trash can
        $("#trashCan").shieldDroppable({
            scope: "treeview-dd-scope",
            hoverCls: "item-trash-dropover",
            tolerance: "touch",
            events: {
                drop: function (e) {
					
					
					console.log(e.draggable);
					sourceId = -999;
					
					
					//sourceId = $("#treeview").swidget("TreeView").getItem($("#treeview").swidget("TreeView").getPath(e.draggable)).id;
					
					sourceId = $("#treeview").swidget("TreeView").getItem($("#treeview").swidget("TreeView").getPath($(e.draggable).closest('.sui-treeview-item'))).id;
					
					if(confirm("Wirklich in den Mülleimer?")) {
						
						if ($(e.draggable).hasClass('sui-treeview-item-text')) {
                        // dropped a treeview item - delete it
                           $("#treeview").swidget("TreeView").remove($(e.draggable).closest('.sui-treeview-item'));
						   $.ajax({
                                url: "updateTree.php",
								data: {"sourceId": sourceId, "targetId": 49}
                            }).done(function (data) {
                               
                            }).fail(function () {
                                
                            });
                        }
                         else {
                        // dropped a doc-item, just delete it from the DOM
                           $(e.draggable).remove();
                        }
                        // disable animation of the droppable, so that it
                       // does not get animated if cancelled
                       e.skipAnimation = true;
						
				    }
                    
                }
            }
        });
		
		
    });
	
	
</script>
<style>
    .container
    {
        max-width: 400px;
        margin: auto;
    }
    .tag-container
    {
        display: inline-block;
        clear: both;
        width: 100%;
        margin-top: 20px;
    }
    .doc-item
    {
        margin: 5px;
        padding-right: 0.3em;
        padding-left: 0.3em;
        padding-top: 0.1em;
        padding-bottom: 0.1em;
        background-color: white;
        border: 1px solid black;
        cursor: default;
    }
    .item-trash
    {
        font-size: 48px;
        float: right;
    }
    .item-trash-dropover
    {
        color: red;
    }
	
	
</style>
</body>
</html>