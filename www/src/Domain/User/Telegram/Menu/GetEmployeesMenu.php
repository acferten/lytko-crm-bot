<?php

namespace Domain\User\Telegram\Menu;

use Domain\Shared\Models\User;
use Domain\User\Telegram\Messages\EmployeeCardMessage;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use Spatie\Permission\Models\Role;

class GetEmployeesMenu extends InlineMenu
{
    public Collection $employees;

    public int $page;

    public function start(Nutgram $bot): void
    {
        $bot_user = User::where('telegram_id', $bot->userId())->first();

        if (is_null($bot_user) || $bot_user->getRoleNames()->doesntContain('administrator')) {
            $this->menuText('🚫 У Вас нет доступа к этой команде.')->showMenu();

            return;
        }

        $this->employees = User::whereNot('id', $bot_user->id)->withoutRole('customer')->get();

        if ($this->employees->isEmpty()) {
            $this->menuText('😯 Пусто! Сотрудников нет.')->showMenu();

            return;
        }

        $this->page = 0;
        $this->getEmployeeLayout($bot);
    }

    public function getEmployeeLayout(Nutgram $bot): void
    {
        // Current employee
        $employee = $this->employees->get($this->page);

        // Generating employee card
        $total = count($this->employees);
        $currentPage = $this->page + 1;
        $card = "<b>Сотрудник {$currentPage} из {$total}</b>\n";
        $card .= EmployeeCardMessage::getCard($employee);

        // Attaching employee info
        $this->clearButtons()->menuText($card, ['parse_mode' => 'html']);

        $this->addButtonRow(InlineKeyboardButton::make('✍️ Изменить роль',
            callback_data: "{$employee->id}@showChangeRoleMenu"));

        // Pagination buttons
        if ($this->employees->get($this->page - 1)) {
            $this->addButtonRow(InlineKeyboardButton::make('◀️ Назад', callback_data: 'back@handlePagination'));
        }
        if ($this->employees->get($this->page + 1)) {
            $this->addButtonRow(InlineKeyboardButton::make('▶️ Далее', callback_data: 'next@handlePagination'));
        }

        // Updating menu message
        $this->orNext('none')
            ->showMenu();
    }

    public function handlePagination(Nutgram $bot): void
    {
        $this->page += $bot->callbackQuery()->data == 'next' ? 1 : -1;

        $this->getEmployeeLayout($bot);
    }

    public function showChangeRoleMenu(Nutgram $bot): void
    {
        $this->clearButtons()->menuText('Вы хотите изменить роль сотрудника на',
            ['parse_mode' => 'html']);

        foreach (Role::whereNot('name', 'customer')->get()->pluck('name') as $role) {
            if (User::find($bot->callbackQuery()->data)->getRoleNames()->first() != $role) {
                $this->addButtonRow(InlineKeyboardButton::make($role,
                    callback_data: "{$role},{$bot->callbackQuery()->data}@changeRole"));
            }
        }

        $this->addButtonRow(InlineKeyboardButton::make('◀️ Вернуться назад', callback_data: 'back@returnBack'))
            ->orNext('none')
            ->showMenu();
    }

    public function returnBack(Nutgram $bot): void
    {
        $this->getEmployeeLayout($bot);
    }

    public function changeRole(Nutgram $bot): void
    {
        $update_info = explode(',', $bot->callbackQuery()->data);
        $role_name = $update_info[0];
        $employee_id = $update_info[1];

        User::find($employee_id)->syncRoles($role_name);

        $this->start($bot);
    }

    public function none(Nutgram $bot): void
    {
        $this->end();
    }
}
