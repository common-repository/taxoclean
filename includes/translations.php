<?php
    if (!function_exists("taxoclean_get_translations")) {
        function taxoclean_get_translations()
        {
            return [
                "lookalikes" => __("Lookalikes", "taxoclean"),
                "orphans" => __("Orphans", "taxoclean"),
                "settings" => __("Settings", "taxoclean"),
                "total_terms" => __("Total terms", "taxoclean"),
                "analyze_of" => __("Analyze of", "taxoclean"),
                "terms" => __("terms", "taxoclean"),
                "lookalike_groups" => __("Lookalike groups", "taxoclean"),
                "merge_left" => __("Merge those", "taxoclean"),
                "merge_right" => __("terms into", "taxoclean"),
                "merge" => __("Merge", "taxoclean"),
                "apply" => __("Apply", "taxoclean"),
                "invert_selection" => __("Invert selection", "taxoclean"),
                "delete_selected" => __("Delete selected", "taxoclean"),
                "search_another_term" => __("Search another term", "taxoclean"),
                "orphan_treshold" => __("Orphan treshold", "taxoclean"),
                "orphan_treshold_desc" => __("Terms with less than this number of posts will be considered orphans.", "taxoclean"),
                "batch_size" => __("Batch size", "taxoclean"),
                "batch_size_desc" => __("Number of terms to process in one batch.", "taxoclean"),
                "taxonomy_to_analyze" => __("Taxonomy to analyze", "taxoclean"),
                "replace" => __("Replace", "taxoclean"),
                "delete" => __("Delete", "taxoclean"),
                "choose" => __("Choose", "taxoclean"),
                "are_you_sure_delete" => __("Are you sure ? Posts will not be deleted, only the taxonomy term will be removed.", "taxoclean"),
                "are_you_sure" => __("Are you sure ?", "taxoclean"),
                "are_you_sure_ignore" => __("Are you sure ? This term will be ignored and will not be displayed in the lookalikes list.", "taxoclean"),
                "no_matching_tag" => __("No matching tag", "taxoclean"),
                "lookalike_level" => __("Lookalike level", "taxoclean"),
                "lookalike_level_desc" => __("Level of similarity between terms to consider them as lookalikes, increase to be more strict.", "taxoclean"),
                "ignore_list" => __("Ignore list", "taxoclean"),
                "unignore" => __("Unignore", "taxoclean"),
                "ignores" => __("Ignored terms", "taxoclean"),
	            "no_ignored" => __("No ignored terms", "taxoclean"),
	            "all_unselect" => __("Unselect all", "taxoclean"),
	            "orphan_terms" => __("orphan terms", "taxoclean"),
	            "posts_will_be_updated" => __("posts will be updated", "taxoclean"),
	            "about" => __("About", "taxoclean"),
	            "about_text" => __("Taxoclean is a plugin to help you clean your taxonomies.<br>It will help you find lookalike terms, and merge them.<br>It will also help you find orphan terms, and delete them.", "taxoclean"),
	            "license" => __("License", "taxoclean"),
	            "license_desc" => __("Enter your license key", "taxoclean"),
	            "license_link" => __("Get your license key", "taxoclean"),
	            "error_license" => __("Error: license key is not valid or already used on another domain", "taxoclean"),
	            "number_of_cleaned_terms" => __("Number of cleaned terms", "taxoclean"),
	            "lookalikes_text" => __("Lookalike terms are terms that are very similar to each other.<br>They are often the result of a typo, or a mistake. You can merge them to keep only one term.", "taxoclean"),
	            "orphans_text" => __("Orphan terms are terms that are not used in any post. You can delete them or reassign posts to another term.", "taxoclean"),
	            "ignores_text" => __("Ignored terms are terms that you don't want to see in the lookalikes and orphans list.", "taxoclean"),
	            "fast_mode" => __("Fast mode", "taxoclean"),
	            "fast_mode_desc" => __("Fast mode will skip the check of the affected posts in the lookalikes mode.", "taxoclean"),
	            "current_taxo_desc" => __("Current taxonomy to analyze", "taxoclean"),
	            "updating" => __("Updating", "taxoclean"),
	            "fast_mode_enable" => __("Enable fast mode in the settings screen to skip this step", "taxoclean"),
	            "ignore" => __("Ignore", "taxoclean"),
	            "footer" => __("Taxoclean is powered by <a href='https://www.artwhere.eu' target='_blank'>Artwhere</a>", "taxoclean"),
	            "why_premium" => __("Why premium ?", "taxoclean"),
	            "why_premium_text" => __("Premium version of Taxoclean will allow you to:
					<ul>
						<li>· Select which terms you want to merge in lookalike mode.</li>
						<li>· Bulk actions in orphans mode to delete many tags in one action.</li>
						<li>· Ignore some terms.</li>						
					</ul>", "taxoclean"),
	            "select_0" => __("Select all 0 posts terms", "taxoclean"),
	            "selected" => "termes sélectionnés"
            ];
        }
    }
