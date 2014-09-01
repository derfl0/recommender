<? if (!$courses): ?>
<p><?= sprintf(_('Leider wurden keine interessanten Kurse für %s gefunden'), $semester->name) ?></p>
<? else: ?>
    <table class="default">
        <caption><?= _('Interessante Kurse') ?></caption>
        <thead>
            <tr>
                <th><?= _('Veranstaltungsnummer') ?></th>
                <th><?= _('Name') ?></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($courses as $course): ?>
                <tr>
                    <td><a href="<?= UrlHelper::getLink('details.php', array('sem_id' => $course->id)) ?>"><?= $course->Veranstaltungsnummer ?></a></td>
                    <td><a href="<?= UrlHelper::getLink('details.php', array('sem_id' => $course->id)) ?>"><?= $course->name ?></a></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
<? endif; 