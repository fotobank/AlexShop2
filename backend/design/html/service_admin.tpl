{capture name=tabs}
    {$class = 'class = "active"'}
    {if in_array('antivirus', $manager->permissions)}
        <li {$class}>
            <a href = "index.php?module=Antivirus.php">Антивирус</a>
        </li>
        {$class = ''}
    {/if}
    {if in_array('dump', $manager->permissions)}
        <li {$class}>
            <a href = "index.php?module=MySqlDumper.php">База данных</a>
        </li>
        {$class = ''}
    {/if}
{/capture}
