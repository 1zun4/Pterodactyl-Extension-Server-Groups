export default function GroupTitle({ name, color }: { name: string; color: string }) {
    return (
        <h2 className='sgr:flex sgr:items-center sgr:gap-2 sgr:font-header sgr:text-sm sgr:font-semibold sgr:uppercase sgr:tracking-wide sgr:text-foreground'>
            <span className='sgr:h-2.5 sgr:w-2.5 sgr:rounded-full' style={{ backgroundColor: color }} />
            {name}
        </h2>
    );
}
