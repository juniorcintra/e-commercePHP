Rain TPL 3
------------

New features:
Better parser in less code
Plugins system to add functionality (included path_replace and image_resize plugins)
Back-compatibility with Rain TPL 2 templates
Cascade modifier, {$title|strtolower|ucfirst}
Register Tag, to create custom tags that call closure functions, example: {@translate this text@}
Loop tag improved: {loop="list" as $i => $array} ... {/loop} and {loop="range(0,3)" as $i }
Modifier can be called into if tag {if="$title|streln > 10"} ... {/if}
Added Clean() method to delete old cache files
Added autoescape
Removed Static Cache
More examples


ToDo/Wish list:
Short syntax: {loop $var} {if $var}
Template auto generation, in debug mode if a template was not found RainTPL create a dummy template with all the variables used and loop
Better Sandbox with White List, so with addModifier
Better Error management
AddTemplateFolder, possibility to define an alternative template folder so if a template is not found will search on the other folder