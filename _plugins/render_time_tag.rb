require 'set'
Jekyll::Hooks.register :site, :post_read do |site|
  degrees = []
  degree_map = {}

  jobs = []
  job_map = {}
  total_jobs = 0

  genders = []
  gender_map = {}

  full_timers = []

  techrangers = site.collections['techrangers_past'].docs | site.collections['techrangers_current'].docs
  techrangers.each do |person|

    # collect degrees
    if person.data['degrees']
      person.data['degrees'].each do |degree|
        if !degree_map.has_key? degree
          thisDegree = {'title' => degree, 'people' => []}
          degrees << thisDegree
          degree_map[degree] = thisDegree
        else
          thisDegree = degree_map[degree]
        end
        thisDegree['people'] << person
      end
    end

    # collect employers
    if person.data['also_employed_by']
      person.data['also_employed_by'].each do |job|
        total_jobs += 1
        if !job_map.has_key?(job)
          thisJob = {'title' => job, 'people' => []}
          jobs << thisJob
          job_map[job] = thisJob
        else
          thisJob = job_map[job]
        end
        thisJob['people'] << person
      end
    end

    # collect gender
    if person.data['gender']
      gender = person.data['gender'].to_s
      if !gender_map.has_key?(gender)
        thisGender = {'title' => gender, 'count' => 0}
        genders << thisGender
        gender_map[gender] = thisGender
      else
        thisGender = gender_map[gender]
      end
      thisGender['count'] += 1
    end

    # collect fullTimers
    if person.data['full_time']
      full_timers << person
    end

  end

  jobs.sort_by! { |a| a['people'].size }
  degrees.sort_by! { |a| a['people'].size }
  genders.sort_by! { |a| a['count'] }


  site.config['tr'] = {'tr_count' => techrangers.size, 'jobs' => jobs.reverse!, 'total_jobs' => total_jobs, 'degrees' => degrees.reverse!, 'genders' => genders.reverse}
end


module ArraySlice
  def array_slice(input, start, length)
    input.slice(start, length)
  end

  def combine_some_into(input, count_param, compare, compare_to, title)
    compare_to = compare_to.to_i
    newOutput = []
    others = { 'title' => title }
    others[count_param] = []

    input.each do |i|
      count = i[count_param].size
      if count.send(compare, compare_to)
        newOutput << i
      else
        others[count_param] += i[count_param]
      end
    end

    newOutput << others
    newOutput
  end
end

Liquid::Template.register_filter(ArraySlice)

