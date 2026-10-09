export default function GroupPill({ name, color }: { name: string; color: string }) {
    return (
        <span className='sgr:inline-flex sgr:items-center sgr:gap-1.5 sgr:rounded-full sgr:bg-muted sgr:px-2 sgr:py-0.5 sgr:text-xs sgr:text-foreground'>
            <span className='sgr:h-2 sgr:w-2 sgr:rounded-full' style={{ backgroundColor: color }} />
            {name}
        </span>
    );
}
