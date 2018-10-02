{capture name=tabs}
    {if in_array('antivirus', $manager->permissions)}
        <li>
            <a href = "index.php?module=ServiceAdmin">Антивирус</a>
        </li>
    {/if}
    {if in_array('dump', $manager->permissions)}
        <li class = "active">
            <a href = "index.php?module=ServiceDumper">База данных</a>
        </li>
    {/if}
{/capture}

{$meta_title = "service_dumper.tpl" scope=parent}
