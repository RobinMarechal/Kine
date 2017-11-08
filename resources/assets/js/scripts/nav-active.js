export function navActive() {
    var path = window.location.pathname;
    var routeGroup = path.replace('/', '').split('/')[0];
    
    if(routeGroup == 'admin')
    {
        routeGroup += '-' + path.replace('/', '').split('/')[1];
    }

    if (routeGroup == 'auth') {
        routeGroup = path.replace('/', '').split('/')[1];
    }

    $('#nav-' + routeGroup).addClass('nav-active');
    console.log('#nav-' + routeGroup);

    if (routeGroup == 'notifications') {
        $('li.dropdown > a.dropdown-toggle').addClass('dropdown-selected');
    }
}

