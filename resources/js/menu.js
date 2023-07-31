import {
    mdiMonitor, mdiListStatus, mdiAccountGroup, mdiCogs,
    mdiHandshake, mdiApps, mdiBallot, mdiSort, mdiCloseBoxMultiple
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
                route: 'support_teams.index',
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
    },
    {
        route: 'statuses.index',
        icon: mdiListStatus,
        label: 'Statuses'
    },
    {
        route: 'priorities.index',
        icon: mdiSort,
        label: 'Priorities'
    },
    {
        route: 'close_reasons.index',
        icon: mdiCloseBoxMultiple,
        label: 'Close Reasons'
    },
    {
        route: 'settings.edit',
        icon: mdiCogs,
        label: 'General Settings'
    }
]
