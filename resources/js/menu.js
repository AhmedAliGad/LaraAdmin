import {
    mdiMonitor,
    mdiMessageQuestion,
    mdiAccountGroup,
    mdiHandshake, mdiApps, mdiBallot
} from '@mdi/js'

export default [
    {
        route: 'dashboard',
            icon: mdiMonitor,
            label: 'Dashboard'
    },
    {
        label: "Users",
        icon: mdiAccountGroup,
        children: [
            {
                label: "Clients",
                route: 'user.index',
            },
            {
                label: "Support Team",
                route: 'user.index',
            },
        ],
    },
    {
        route: 'projects.index',
        icon: mdiApps,
        label: 'Projects'
    },
    {
        route: 'companies.index',
        icon: mdiHandshake,
        label: 'Companies'
    },
    {
        route: 'tickets.index',
        icon: mdiBallot,
        label: 'Tickets'
    }
]
