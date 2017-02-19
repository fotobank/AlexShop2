{capture name=tabs}
    {if in_array('antivirus', $manager->permissions)}
        <li class = "active">
            <a href = "index.php?module=ServiceAdmin.php">Антивирус</a>
        </li>
    {/if}
{/capture}

{$meta_title = "Антивирус" scope=parent}
