import Bug from "../models/Bug";
import Flash from "../libs/flash/Flash";
import Helper from "../helpers/Helper";

async function updateBug(btn, solve) {
    const tr = btn.parents('[data-id]');
    const id = tr.data('id');
    const wasSolved = tr.data('solved');
    let bug = new Bug();
    bug.id = id;
    bug.solved_at = solve ? Helper.currentDateTime() : null;

    if (solve && wasSolved || !solve && !wasSolved) {
        alert("Nope. Sry m8, I saw dat cumin");
        return;
    }

    try {
        updateHtml(await bug.update(), tr);
    } catch (e) {
        Flash.error("Une erreur est survenue, le bug n'a pas pu être modifié...");
        console.log(["manageBugs#updateBug", e]);
    }
}

function updateHtml(bug, tr) {
    const buttonSetSolved = tr.find('.bug-controls--set-solved');
    const buttonSetPending = tr.find('.bug-controls--set-pending');
    const tdSolvedAt = tr.children('.bug-solved_at');

    if (bug.solved_at) {
        buttonSetPending.removeClass('hidden');
        buttonSetSolved.addClass('hidden');
        tdSolvedAt.html(Helper.currentDate(false));
        tdSolvedAt.removeClass('center');
        tdSolvedAt.removeClass('red');
        tdSolvedAt.addClass('olive');
        tr.data('solved', true);
    }
    else {
        buttonSetSolved.removeClass('hidden');
        buttonSetPending.addClass('hidden');
        tdSolvedAt.html('-');
        tdSolvedAt.addClass('center');
        tdSolvedAt.addClass('red');
        tdSolvedAt.removeClass('olive');
        tr.data('solved', false);
    }
}

async function solveBug(btn){
    const id = btn.parents('[data-editable="true"]').data('id');

    try{
        const bug = await Bug.get(id);
        bug.solved_at = Helper.currentDateTime();
        await bug.update();

        $('.bug-solved_at').html(`<p>Résolu le ${Helper.currentDate(false)} à ${Helper.currentTime(false)}</p>`);
        btn.remove();
        Flash.success("Le bug a été modifié.");
    }
    catch(e){
        Flash.error("Une erreur est survenue, le bug n'a pas pu être modifié.");
        console.log(["manageBugs#solveBug", e]);
    }

}

export default function manageBugs() {
    $('[data-update=bugs-solved]').click(function () {
        updateBug($(this), true);
    });

    $('[data-update=bugs-pending]').click(function () {
        updateBug($(this), false);
    });

    $('#set-bug-solved').click(function(){
        solveBug($(this));
    });
}