import { mdiMonitor, mdiApps, mdiBallot } from '@mdi/js'
export default [
    {
        route: 'dashboard',
        icon: mdiMonitor,
        label: 'Dashboard'
    },
    {
        route: 'projects.index',
        icon: mdiApps,
        label: 'Projects'
    },
    {
        route: 'tickets.index',
        icon: mdiBallot,
        label: 'Tickets'
    },
]
