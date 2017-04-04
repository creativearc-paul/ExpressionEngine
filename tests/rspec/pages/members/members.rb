class Members < ControlPanelPage

  element :member_search, 'input[name=search]'
  element :member_actions, 'select[name=bulk_action]'
  element :member_table, 'table'
  elements :members, 'table tbody tr'

  def load
    main_menu.members_btn.click
  end
end
