<style>
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .transition-transform {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }


    @media (min-width: 768px) {
        .main.active {
            margin-left: 0px;
            width: 100%;
        }
    }

    @media (min-width: 768px) {
        .md\:ml-64 {
            margin-left: 16rem;
        }

        .md\:hidden {
            display: none;
        }

        .md\:w-\[calc\(100\%-256px\)\] {
            width: calc(100% - 256px);
        }

        .md\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .lg\:col-span-2 {
            grid-column: span 2 / span 2;
        }

        .lg\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .lg\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
</style>

<!--sidenav -->
<div class="fixed left-0 top-0 w-64 h-full bg-base-100 p-4 mt-16 z-50 sidebar-menu transition-transform -translate-x-full">
    <ul class="mt-4">
        <li class="mb-1 group">
            <a href="/overall" class="flex font-semibold items-center py-2 px-4 text-neutral-700 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-border-all mr-2"></i>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group">
            <a href="/users" class="flex font-semibold items-center py-2 px-4 text-neutral-700 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-users mr-2"></i>
                <span class="text-sm">Users</span>
            </a>
        </li>
        <li class="mb-1 group">
            <a href="/posts" class="flex font-semibold items-center py-2 px-4 text-neutral-700 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-inbox mr-2"></i>
                <span class="text-sm">Posts</span>
            </a>
        </li>

        <li class="mb-1 group">
            <a href="/access" class="flex font-semibold items-center py-2 px-4 text-neutral-700 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="fa-solid fa-lock mr-2"></i>
                <span class="text-sm">Access</span>
            </a>
        </li>


    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay hidden"></div>