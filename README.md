# grid-relationship-field
Core Purpose:

Create the functionality which {parents field="grid_field:relationship_field"} should provide by parsing in our entry_id.

Basic Usage Example:

```
{exp:channel:entries}
{exp:grid_relationship_field child_id="{entry_id}"}
<p><a href="/{segment_1}/{parent_url_title}">{parent_title}</h3></a></p>
{/exp:grid_relationship_field}
{/exp:channel:entries}
```

{parent_count} {parent_entry_id} {parent_title} {parent_url_title} are all available tags we can use. This allows us to link through to the child entry from our grid field. If more data is needed just parse the {parent_entry_id} through an embed to load a second channel entries tags and then target any additional fields you wish to display.