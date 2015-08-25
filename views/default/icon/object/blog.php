<?php
$entity = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);

// do we have a blog
if (!empty($entity) && elgg_instanceof($entity, "object", "blog")) {
	$href = elgg_extract("href", $vars, $entity->getURL());

	$class = array("blog_tools_blog_image");
	if (isset($vars["class"])) {
		$class[] = $vars["class"];
	}

	$image_params = array(
		"alt" => $entity->title,
		"class" => elgg_extract("img_class", $vars, "")
	);

	$image_params["src"] = $entity->getIconURL(elgg_extract("size", $vars, "medium"));

	if ($full_view) {
		$size = elgg_get_plugin_setting("full_size", "blog_tools", "large");
		$align = elgg_get_plugin_setting("full_align", "blog_tools", "right");
	} else { // listing view
		$size = elgg_get_plugin_setting("listing_size", "blog_tools", "small");
		$align = elgg_get_plugin_setting("listing_align", "blog_tools", "right");
	}

	if ($size == "extralarge") {
		$image_params["src"] = $entity->getIconURL("master");
	} else {
		$image_params["src"] = $entity->getIconURL($size);
	}

	$class[] = "blog-tools-blog-image-" . $size;

	if ($align == "right") {
		$class[] = "float-alt";
	} else {
		$class[] = "float";
	}

	// does the blog have an image
	if ($entity->icontime && $align != "none") {
		echo "<div class='" . implode(" ", $class) . "'>";
		$image = elgg_view("output/img", $image_params);

		if (!empty($href)) {
			$params = array(
				"href" => $href,
				"text" => $image,
				"is_trusted" => true,
			);
			$class = elgg_extract("link_class", $vars, "");
			if ($class) {
				$params["class"] = $class;
			}

			echo elgg_view("output/url", $params);
		} else {
			echo $image;
		}

		echo "</div>";
	} else {
		echo "<!-- do not show blog image -->"; // make sure something is returned
	}
}