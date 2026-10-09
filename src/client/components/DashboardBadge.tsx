import { useQuery } from '@tanstack/react-query';
import type { SdkServer } from '@pterodactyl/sdk';
import { getClientGroups, keys } from '../api';
import GroupPill from './GroupPill';

export default function DashboardBadge({ data: server }: { data: SdkServer }) {
    const groups = useQuery({ queryKey: keys.client, queryFn: getClientGroups, staleTime: 60_000 });
    const mine = (groups.data ?? []).filter((group) => group.servers.some((item) => item.uuid === server.attributes.uuid));

    if (mine.length === 0) {
        return null;
    }

    return (
        <span className='sgr:ml-3 sgr:inline-flex sgr:shrink-0 sgr:gap-1'>
            {mine.map((group) => (
                <GroupPill key={group.id} name={group.name} color={group.color} />
            ))}
        </span>
    );
}
